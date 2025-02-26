function hideDialog(name) {
    setTimeout(() => {
        var dialog = document.querySelector('#' + name);
        if ('animate' in dialog && !document.body.classList.contains('reduced-motion')) {
            //Reversed CSS @keyframes expand-middle:
            dialog.animate([
                {
                    opacity: 1,
                    transform: 'scale(1) var(--dialog-polyfilled-center)'
                }, {
                    opacity: 0,
                    transform: 'scale(.8) var(--dialog-polyfilled-center)'
                }
            ], {
                duration: 250,
                easing: 'cubic-bezier(.4, 0, .2, 1)'
            }).onfinish = () => {
                dialog.close();
            };
        } else {
            dialog.close();
        }
    }, 0);//avoids race conditions, as handleHash's showDialog() is also always in a setTimeout() 
}

document.addEventListener('DOMContentLoaded', function() {

    var dialogs = document.querySelectorAll('dialog');
    //Have content that gets added dynamically:
    var stateDialogs = ['downloads', 'share', 'blockedDl', 'actionRequired', 'fsa', 'unlockReward'];
    //All content inside is lazy-loaded:
    var lazyDialogs = ['terms', 'refunds', 'termsReferral', 'privacy', 'actionRequired', 'gdriveAndroid'];

    var watcher;

    if (typeof HTMLDialogElement !== 'function') {
        //The dialog element is not supported by this browser, load the polyfill and init the dialog elements:
        loadStylesheet(ROOT_FOLDER + '/polyfills/dialog/dialog-polyfill.css');
        document.documentElement.style.setProperty('--dialog-polyfilled-center', 'translateY(-50%)');
        loadScript(ROOT_FOLDER + '/polyfills/dialog/dialog-polyfill.js', function () {
            for (var i = 0; i < dialogs.length; i++)
                dialogPolyfill.registerDialog(dialogs[i]);
            initRouter();
        });
    } else {
        initRouter();
    }

    function initRouter() {
        window.onhashchange = handleHash;
        handleHash();
    }

    function handleHash() {
        var hashText = location.hash.substr(1);
        if (hashText == 'options') {
            //For backwards compat:
            hashText = 'settings';
            history.replaceState(null, null, location.pathname + location.search + '#' + hashText);
        }
        setTimeout(function () {
            switch (hashText) {
                case 'terms':
                case 'refunds':
                case 'termsReferral':
                case 'privacy':
                case 'legal':
                case 'account':
                case 'history':
                case 'settings':
                case 'upgrade':
                case 'verifyUpgrade':
                case 'actionRequired':
                case 'downloads':
                case 'blockedDl':
                case 'gdriveAndroid':
                case 'share':
                case 'fsa':
                case 'unlockReward':
                //case 'xmasPromo':
                    showDialog('#' + hashText);
                    break;
            }
        }, !closeDialogs() || document.body.classList.contains('reduced-motion') ? 0 : 200); /* .2s is the hideDialog() animationDuration */

        if (hashText == 'account')
            account.onLoginStateFetched(() => {
                if (account.loggedIn) {
                    loadScript(ROOT_FOLDER + '/js/referrals.js');
                } else {
                    hideDialog('account');
                    account.login();
                }
            });

        if (hashText == 'history')
            loadScript(ROOT_FOLDER + '/js/historyConv.js', function () {
                historyConv.init();
            });

        if (hashText == 'upgrade')
            loadScript(ROOT_FOLDER + '/js/upgrade.js', function () {
                upgrade.init();
                upgrade.shownAt = new Date();
            });

        if (hashText == 'verifyUpgrade')
            loadScript(ROOT_FOLDER + '/js/verifyUpgrade.js', function () {
                verifyUpgrade.init();
            });

        if (lazyDialogs.includes(hashText)) {
            var lazyContentEl = document.querySelector('#' + hashText + ' .lazy-dialog-content');

            if (!lazyContentEl.dataset.loaded) {
                lazyContentEl.textContent = 'Loading...';

                fetch(ROOT_FOLDER + '/template_dialogs_lazy/' + hashText + '.php?v=' + CACHE_VERSION)
                .then(response => {
                    if(response.ok) return response.text();
                    throw Error('Server returned status code ' + response.status);
                })
                .then(html => {
                    lazyContentEl.innerHTML = html;
                    lazyContentEl.dataset.loaded = 1;
                })
                .catch(err => {
                    lazyContentEl.textContent = 'Failed to load content. Try again later.';

                    console.error(err);
                    //Sentry.captureException(err);
                });
            }
        }
    }

    function showDialog(name) {
        var hashText = name.substr(1);
        if (stateDialogs.includes(hashText) && window.loadingStateDialog != hashText) {
            //User has manually tried to visit a stateDialog,
            //abort the attempt:
            history.replaceState(null, null, location.pathname + location.search);
            gtagLogPage();
            logNavSPA();
            updateBodyForDialog();//rewardGAM closing bug workaround
        } else {
            window.loadingStateDialog = '';//consume the announcement that a stateDialog is being loaded on purpose

            //Check needed if the user is spamming back-forward:
            if (!document.querySelector(name).open) {
                updateBodyForDialog(true);
                location.hash = name;
                document.querySelector(name).showModal();
                if ('CloseWatcher' in window) {
                    watcher = new CloseWatcher();
                    watcher.addEventListener('close', () => {
                        if(location.hash == '') return;//may happen after chaining dialogs
                        history.back();
                    });
                }
            }
        }
    }

    for (var i = 0; i < dialogs.length; i++) {
        dialogs[i].addEventListener('click', function (e) {
            //Detect clicking outside of the dialog, on its backdrop:
            if(e.target.tagName.toLowerCase() == 'dialog') hideDialog(e.target.id);
        });
        dialogs[i].addEventListener('close', function (e) {
            if (location.hash == '#' + e.target.id) {
                //Remove the hash in URL,
                //only pushing it to browser history
                //if the dialog doesn't get filled with dynamic content:
                stateDialogs.includes(e.target.id) ? 
                    history.replaceState(null, null, location.pathname + location.search) :
                    history.pushState(null, null, location.pathname + location.search);
                gtagLogPage();
                logNavSPA();
            }
            //Verify that the close event has not fired after another dialog was just opened, e.g. terms>privacy:
            if(location.hash == '') updateBodyForDialog();

            if(watcher) watcher.destroy();

            if(e.target.id == 'downloads' && typeof download !== 'undefined') download.unloadDialog();
            if(e.target.id == 'blockedDl' && typeof download !== 'undefined') download.samsungUnloadBlockedDialog();
            if(e.target.id == 'share' && typeof sharer !== 'undefined') sharer.unloadDialog();
            if(e.target.id == 'fsa' && typeof fsa !== 'undefined') fsa.unloadDialog();
            if(e.target.id == 'upgrade' && typeof upgrade !== 'undefined' && !(upgrade instanceof HTMLElement)) upgrade.onClose();
        });
    }
    function closeDialogs() {
        var dialogClosed;
        for (var i = 0; i < dialogs.length; i++)
            if (dialogs[i].open) {
                hideDialog(dialogs[i].id);
                dialogClosed = true;
            }
        return dialogClosed;
    }

    function updateBodyForDialog(shown) {
        //Scroll lock:
        document.body.style.overflow = shown ? 'hidden' : '';
    }
});document.addEventListener('DOMContentLoaded', function() {
    // Dark theme:
    var darkThemeElem = document.querySelector('#darkTheme');
    if (storage.get('local', 'theme') === null) {
        storage.set('local', 'theme', 'default');
    } else {
        darkThemeElem.value = storage.get('local', 'theme');
    }
    function setThemeStyles(toDark) {
        if (toDark) {
            document.body.classList.add('dark');
            document.querySelector('.stpd_cmp')?.classList.add('stpd_dark');
        } else {
            document.body.classList.remove('dark');
            document.querySelector('.stpd_cmp')?.classList.remove('stpd_dark');
        }
        document.documentElement.style.colorScheme = 'only ' + (toDark ? 'dark' : 'light');
        document.querySelector('meta[name="theme-color"]').setAttribute(
            'content',
            toDark && VIEW != 'blog' ? '#000' : '#2e5598'
        );
    }
    function applyTheme() {
        switch (storage.get('local', 'theme')) {
            case 'light':
                setThemeStyles(false);
                break;
            case 'dark':
                setThemeStyles(true);
                break;
            case 'default':
                setThemeStyles(window.matchMedia('(prefers-color-scheme: dark)').matches);
                break;
        }
        document.body.classList.add('theme-loaded');
    }
    darkThemeElem.addEventListener('change', function () {
        storage.set('local', 'theme', darkThemeElem.value);
        applyTheme();
    });
    window.matchMedia('(prefers-color-scheme: dark)').addListener(function () {
        //Theme changed from OS settings. Reflect that:
        applyTheme();
    });
    applyTheme();
    
    
    // Reduced motion:
    var reducedMotionElem = document.querySelector('#reducedMotion');
    if (storage.get('local', 'reduced_motion') === null) {
        storage.set('local', 'reduced_motion', 'default');
    } else {
        reducedMotionElem.value = storage.get('local', 'reduced_motion');
    }
    function applyMotion() {
        switch (storage.get('local', 'reduced_motion')) {
            case 'off':
                document.body.classList.remove('reduced-motion');
                break;
            case 'on':
                document.body.classList.add('reduced-motion');
                break;
            case 'default':
                window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 
                    document.body.classList.add('reduced-motion') : document.body.classList.remove('reduced-motion');
                break;
        }
    }
    reducedMotionElem.addEventListener('change', function () {
        storage.set('local', 'reduced_motion', reducedMotionElem.value);
        applyMotion();
    });
    applyMotion();


    //Auto-download complete items:
    var chkAutoDls = document.querySelectorAll('.chk-auto-dl');
    if (storage.get('local', 'auto_dl') === null)
        storage.set('local', 'auto_dl', browserCompat.isSamsungBlockingDownload() ? '' : 'checked');
    function applyAutoDl() {
        chkAutoDls.forEach(function (el) {
            el.querySelector('input[type="checkbox"]').checked = storage.get('local', 'auto_dl');
        });
    }
    chkAutoDls.forEach(function (el) {
        el.querySelector('input[type="checkbox"]').addEventListener('change', function () {
            if (storage.get('local', 'auto_dl') == '' && browserCompat.isSamsungBlockingDownload()) {
                document.querySelector('#continueDlContainer').style.display = 'none';
                window.loadingStateDialog = 'blockedDl';
                window.location = '#blockedDl';
            }
            storage.set('local', 'auto_dl', storage.get('local', 'auto_dl') == 'checked' ? '' : 'checked');
            applyAutoDl();
        });
    });
    applyAutoDl();


    //Push web notifications:
    var chkNotifications = document.querySelectorAll('.chk-notifications');
    if (storage.get('local', 'notifications') === 'checked' && !notifs.allowed())
        storage.set('local', 'notifications', '');
    if (storage.get('local', 'notifications') === null)
        storage.set('local', 'notifications', notifs.allowed() ? 'checked' : '');
    function applyNotifications() {
        chkNotifications.forEach(function (el) {
            el.querySelector('input[type="checkbox"]').checked = storage.get('local', 'notifications');
        });
    }
    chkNotifications.forEach(function (el) {
        el.querySelector('input[type="checkbox"]').addEventListener('change', function () {
            applyNotifications();
            if (!window.Notification) {
                if (browserCompat.isWebkit())
                    alert('Due to iOS restrictions, launch MConverter from your home screen to enable notifications.\n' +
                        'Tap on Share > Add to Home Screen.');
                else
                    alert('Sorry, your platform does not support web notifications.');
                logEvt('request_permission', {
                    'event_category': 'notifications',
                    'event_label': 'Not supported'
                });
                return;
            }
            notifs.clear();//for disabling notifications with the checkbox
            Notification.requestPermission()
            .then(async permission => {
                switch (permission) {
                    case 'granted':
                        storage.set('local', 'notifications',
                            storage.get('local', 'notifications') == 'checked' ? '' : 'checked');
                        applyNotifications();
                        break;
                    case 'default':
                    case 'denied':
                        const relatedApps = await navigator.getInstalledRelatedApps?.() || [];
                        let hasApp = false;
                        relatedApps.forEach(app => {
                            if (app.id == 'eu.mconverter.twa') {
                                hasApp = true;
                                if (storage.get('session', 'twa_version') > 21 && browserCompat.isTWABridgeAvailable())
                                    loadScript(ROOT_FOLDER + '/js/bridgeTWA.js', () => {
                                        bridgeTWA.open('notification-settings', () => {
                                            //App will restart from Java
                                        });
                                    });
                                else
                                    alert('Please enable notifications for the MConverter app from Android settings. You may need to restart it.');
                            }
                        });

                        if (!hasApp)
                            alert('Please enable notifications from your browser settings and try again.');
                }
                logEvt('request_permission', {
                    'event_category': 'notifications',
                    'event_label': 'New status: ' + permission
                });
            });
        });
    });
    applyNotifications();


    //Keep original file names when downloading:
    var origNamesLoaded, chkOrigNames = document.querySelectorAll('.chk-orig-names');
    if (storage.get('local', 'orig_names') === null)
        storage.set('local', 'orig_names', '');
    function applyOrigNames() {
        chkOrigNames.forEach(function (el) {
            el.querySelector('input[type="checkbox"]').checked = storage.get('local', 'orig_names');
        });

        if (storage.get('local', 'orig_names') == 'checked') {
            account.onLoginStateFetched(() => {
                //Only trigger when the user has clicked the checkbox,
                //i.e. not on first page load:
                if (origNamesLoaded && (!account.loggedIn || !account.activePurchase)) {
                    storage.set('local', 'orig_names', '');
                    applyOrigNames();
                    loadScript(ROOT_FOLDER + '/js/upgrade.js', () => {
                        upgrade.setUpgradeHeadings('Remove branding from file names');
                    });
                    location.href = '#upgrade';
                    logEvt('see_upgrade_dialog', { 'event_category': 'premium', 'event_label': 'From Original Names Option' });
                }
                origNamesLoaded = true;
            });
        } else {
            origNamesLoaded = true;
        }
    }
    chkOrigNames.forEach(function (el) {
        el.querySelector('input[type="checkbox"]').addEventListener('change', function () {
            storage.set('local', 'orig_names', storage.get('local', 'orig_names') == 'checked' ? '' : 'checked');
            applyOrigNames();
        });
    });
    applyOrigNames();
    //Needed for updating state when logging in/out:
    window.setOrigNamesOption = (on) => { 
        storage.set('local', 'orig_names', on ? 'checked' : '');
        applyOrigNames();
    };


    //PWA custom install prompt on Webkit:
    var chkPWAWebkitPrompt = document.querySelectorAll('.chk-pwa-webkit-prompt');
    if (storage.get('local', 'pwa_webkit_prompt') === null)
        storage.set('local', 'pwa_webkit_prompt', 'checked');
    function applyPWAWebkitPrompt() {
        chkPWAWebkitPrompt.forEach(function (el) {
            el.querySelector('input[type="checkbox"]').checked = storage.get('local', 'pwa_webkit_prompt');
        });
    }
    chkPWAWebkitPrompt.forEach(function (el) {
        //Show checkbox only on Webkit and when not in the installed PWA:
        if(browserCompat.isWebkit() && !navigator.standalone) el.style.display = '';
        el.querySelector('input[type="checkbox"]').addEventListener('change', function () {
            pwaPrompt.webkit.webcomponent?.hideDialog?.();
            storage.set('local', 'pwa_webkit_prompt', storage.get('local', 'pwa_webkit_prompt') == 'checked' ? '' : 'checked');
            applyPWAWebkitPrompt();
        });
    });
    applyPWAWebkitPrompt();


    //Convert on-device:
    var chkOnDevice = document.querySelectorAll('.chk-on-device');
    if (storage.get('local', 'on_device') === null)
        storage.set('local', 'on_device', browserCompat.isSamsungBlockingDownload() ? '' : 'checked');
    function applyOnDevice() {
        chkOnDevice.forEach(function (el) {
            el.querySelector('input[type="checkbox"]').checked = storage.get('local', 'on_device');
        });
    }
    chkOnDevice.forEach(function (el) {
        el.querySelector('input[type="checkbox"]').addEventListener('change', function () {
            toast.show("Setting won't apply for conversions already in progress.", 5000, "OK", function () {
                toast.hide();
            });
            storage.set('local', 'on_device', storage.get('local', 'on_device') == 'checked' ? '' : 'checked');
            applyOnDevice();
        });
    });
    applyOnDevice();


    //Clear previously used formats:
    var btnClearRecent = document.querySelector('#btnClearRecent');
    btnClearRecent.addEventListener('click', () => {
        btnClearRecent.disabled = true;

        var formData = new FormData();
        formData.append('clear', 1);

        fetch(ROOT_FOLDER + '/cf_nocache/ajax/recent_formats.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if(response.ok) return response.json();
            throw Error('Server returned status code ' + response.status);
        })
        .then(data => {
            btnClearRecent.disabled = false;
            if (data.success) {
                hideDialog('settings');
                toast.show("Cleared successfully.", 4000, "OK", function () {
                    toast.hide();
                });

                //Reload the list:
                typeof convertList !== 'undefined' &&
                    typeof targetFormats !== 'undefined' &&
                    !targetFormats.selectedFormat.name &&
                    convertList.fetchTargetFormats();
            }
        })
        .catch(err => {
            console.error(err);
            //Sentry.captureException(err);
        });
    });
});var utils = {
    debounce: function (func, wait, immediate) {
        var timeout;

        return function executedFunction() {
            var context = this;
            var args = arguments;
    
            var later = function () {
                timeout = null;
                if(!immediate) func.apply(context, args);
            };
    
            var callNow = immediate && !timeout;
    
            clearTimeout(timeout);
    
            timeout = setTimeout(later, wait);
    
            if(callNow) func.apply(context, args);
        };
    },
    unixToDateTimeSec: function (unixTimestamp) {
        return new Date(unixTimestamp * 1000).toLocaleString();
    },
    unixToDateTime: function (unixTimestamp) {
        return new Date(unixTimestamp * 1000).toLocaleString([], {
            year: 'numeric', month: 'numeric', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    },
    unixToDate: function (unixTimestamp) {
        return new Date(unixTimestamp * 1000).toLocaleDateString();
    },

    focusNoKeyboard: function (inputField) {
        //Focus an input field without showing virtual/on-screen keyboard
        var oldMode = inputField.inputMode;
        inputField.inputMode = 'none';
        inputField.focus();
        setTimeout(() => {
            inputField.inputMode = oldMode;
        }, 1);
    },

    loadingPage: `<!DOCTYPE html><title>Please wait...</title><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="color-scheme" content="dark light"><style>body,html{height:100%;margin:0}body{display:grid;place-items:center}svg{animation:r 1.6s linear infinite}@keyframes r{from{transform:rotate(0)}to{transform:rotate(270deg)}}circle{stroke:#4D8FFE;stroke-dasharray:187;stroke-dashoffset:0;transform-origin:center;animation:d 1.6s ease-in-out infinite}@keyframes d{0%{stroke-dashoffset:187}50%{stroke-dashoffset:46.75;transform:rotate(135deg)}100%{stroke-dashoffset:187;transform:rotate(450deg)}}</style><svg width="65" height="65" viewBox="0 0 66 66"><circle fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>`
};//Popups for login and payments:
var pups = {
    list: {/* windows opened at least once, may be currently closed */},

    open: function (url, id, width, height, left, top) {
        if (this.list[id] && !this.list[id].closed) {
            this.list[id].focus();
            return true;
        }

        //Specify null for full screen and centered window:
        width = width || window.screen.width;
        height = height || window.screen.height;
        left = left || window.screen.width / 2 - width / 2;
        top = top || window.screen.height / 2 - height / 2;

        var w = window.open('', id, "width="+width+",height="+height+",left="+left+",top="+top);
        if(!w) return false;//Popup blocker probably

        this.list[id] = w;
        try {
            w.document.write(utils.loadingPage);
        } catch (err) {
            //May happen rarely, the URL navigation should still work
        }
        w.location.href = url;
        return true;
    }
};var navDrawer = {
    dom: {},
    isHidden: true,
    _lastTouchY: 0,
    _wasScrolling: false,
    _hasBackEntry: false,
    _closeWatcher: null,
    init: function () {
        this.dom = {
            nav: document.querySelector('nav'),
            drawerOpener: document.querySelector('#drawerOpener')
        };

        /* Drawer touch movement */
        this.dom.nav.addEventListener('touchstart', function (e) {
            this._lastTouchY = e.changedTouches[0].clientY;
            this.dom.nav.classList.add('touching');
        }.bind(this));
        this.dom.nav.addEventListener('touchmove', function (e) {
            //Workaround for Chromium rounding issue(?) which sometimes causes 1px difference when the heights should be equal:
            var fullHeightVisible = Math.abs(this.dom.nav.scrollHeight - this.dom.nav.clientHeight) < 2;
            if (!fullHeightVisible && (e.changedTouches[0].clientY < this._lastTouchY || this.dom.nav.scrollTop || this._wasScrolling)) {
                //Handle drawer larger than viewport height:
                this._wasScrolling = true;
                return;
            }
            e.preventDefault();

            var pos = e.changedTouches[0].clientY - this._lastTouchY;
            if(pos<0) pos = 0;// Do not allow over-swiping the drawer up
            this.dom.nav.style.setProperty('--drawer-pos', pos + 'px');
        }.bind(this));
        this.dom.nav.addEventListener('touchend', function () {
            this._startClosing(
                parseInt(this.dom.nav.style.getPropertyValue('--drawer-pos')) < this.dom.nav.clientHeight/5
            );
        }.bind(this));

        /* Update drawer state after finishing 'close' animation */
        this.dom.nav.addEventListener('transitionend', function (e) {
            if (e.target.tagName == 'NAV' &&
                this.dom.nav.style.getPropertyValue('--drawer-pos') == '100%')
                this.close();
        }.bind(this));
        
        /* Close drawer from clicks anywhere */
        document.addEventListener('click', function (e) {
            if(this.isHidden) return;
            if(!e.target.closest('nav')) e.preventDefault();
            this._startClosing();
        }.bind(this));
        /* Close drawer from outside touches */
        document.addEventListener('touchstart', function (e) {
            if(this.isHidden || e.target.closest('nav')) return;
            this._startClosing();
        }.bind(this));
        /* Close drawer from browser back button */
        window.addEventListener('popstate', function () {
            //Do not fire also when a dialog item is selected from the drawer:
            if (!this.isHidden && !location.hash) {
                this._startClosing();
                this._hasBackEntry = false;
            }
        }.bind(this));

        /* Detect page resizes */
        var debouncedDrawerResize = utils.debounce(function () {
            //Close when desktop bottom bar is active:
            if(window.matchMedia('(min-width: 850px)').matches) navDrawer.close();
        }, 100);
        window.addEventListener('resize', debouncedDrawerResize);

        this.close();
    },
    _startClosing: function (keepOpen) {
        this.dom.nav.classList.remove('touching');
        this._wasScrolling = false;
        this.dom.nav.style.setProperty('--drawer-pos', keepOpen ? '0' : '100%');
    },
    open: function () {
        this.isHidden = false;
        this.dom.drawerOpener.classList.add('hidden');
        document.body.style.pointerEvents = 'none';//prevent :hover sticking on mobile
        setTimeout(function () {
            this.dom.nav.style.setProperty('--drawer-pos', '0');
            this.dom.nav.focus();
        }.bind(this), 100);
        if ('CloseWatcher' in window) {
            this._closeWatcher = new CloseWatcher();
            /* Close drawer from ESC or Android back button */
            this._closeWatcher.addEventListener('close', () => this._startClosing());
        } else if (!this._hasBackEntry) {
            //CloseWatcher not supported,
            //fall back to the History API:
            history.pushState(null, null);
            this._hasBackEntry = true;
        }
        this.dom.nav.removeAttribute('inert');
    },
    close: function () {
        this.isHidden = true;
        this.dom.drawerOpener.classList.remove('hidden');
        document.body.style.pointerEvents = '';
        this.dom.nav.style.setProperty('--drawer-pos', '100%');
        if(this._closeWatcher) this._closeWatcher.destroy();
        //Don't set when desktop bottom nav is active:
        if (window.matchMedia('(max-width: 850px)').matches)   
            this.dom.nav.setAttribute('inert', '');
        else
            this.dom.nav.removeAttribute('inert');//when resizing from drawer to desktop
    }
};var account = {
    dom: {},

    fetchFailed: false, /* true if fetch from server failed repeatedly */
    loggedIn: null, /* true/false later */
    data: {},
    activePurchase: null,
    currentPlan: 'free',
    purchases: [],
    providers: {}, /* supported OAuth providers */
    testGroup: null, /* 0 or 1 later, A/B test groups */

    bc: null, /* broadcast channel for other tabs, for logging in/out */

    _purchaseExpiresCheck: null, /* setTimeout, when the active purchase expires */

    init: function () {
        this.dom.btnTop = document.querySelector('#btnAccountTop');
        this.dom.btnUpgradeTop = document.querySelector('#btnUpgradeTop');
        this.dom.linkUpgradeMobile = document.querySelector('#linkUpgradeMobile');
        this.dom.drawerAvatar = document.querySelector('#drawerAvatar');
        this.dom.txtAccountDrawer = document.querySelector('#txtAccountDrawer');
        this.dom.avatar = document.querySelector('#avatar');
        this.dom.email = document.querySelector('#accEmail');
        this.dom.stats = document.querySelector('#accStats');
        this.dom.accPrefsContainer = document.querySelector('#accPrefs');
        this.dom.otherSessContainer = document.querySelector('#accOtherSess');
        this.dom.txtOtherSess = document.querySelector('#txtOtherSess');
        this.dom.referralsContainer = document.querySelector('#accReferrals');
        this.dom.boxReferral = document.querySelector('#boxReferral');
        this.dom.linkReferral = document.querySelector('#linkReferral');
        this.dom.btnReferral = document.querySelector('#btnReferral');
        this.dom.noPurchases = document.querySelector('#noPurchases');
        this.dom.purchases = document.querySelector('#purchases');
        this.dom.purchasesContainer = document.querySelector('#accPurchases');
        this.dom.purchaseTemplate = document.querySelector('#purchaseTemplate');
        this.dom.purchasesList = document.querySelector('#purchasesList');
        this.dom.btnManagePayments = document.querySelector('#btnManagePayments');
        this.dom.txtManageStripe = document.querySelector('#txtManageStripe');

        this._detectReferral();
        this.checkLoginState();
        this._checkForMsgs();

        if ('BroadcastChannel' in self) {
            this.bc = new BroadcastChannel('account');
            this.bc.onmessage = (e) => {
                if (e.data == 'check-login-state')
                    this.checkLoginState();
            };
        }
    },
    checkLoginState: function (queryParams = {}, attemptCnt = 0) {
        this.fetchFailed = false;

        if(storage.get('session', 'adwords')) queryParams.force_group = 0;

        fetch(ROOT_FOLDER + '/cf_nocache/ajax/get_account.php?' + new URLSearchParams(queryParams))
        .then(response => {
            if(response.ok) return response.json();
            throw Error('Server returned status code ' + response.status);
        })
        .then(data => {
            //PROXY_DL_DOMAIN = data._proxy_dl_domain;
            var wasLoggedIn = this.loggedIn;

            this.loggedIn = data.logged_in;
            this.data = data.user_data;
            this.activePurchase = data.active_purchase;
            this.currentPlan = data.current_plan;
            this.purchases = data.purchases;
            this.purchaseRewarded = data.purchase_rewarded;
            this.canBeRewarded = data.can_be_rewarded;
            this.providers = data.providers;
            if(this.testGroup === null) this.testGroup = data.test_group;

            window.dispatchEvent(new CustomEvent('login-state-changed'));

            if (this.loggedIn) {
                var avatarSrc =
                    this.data.avatar.length ?
                    this.data.avatar :
                    ROOT_FOLDER + '/img/avatar.php?char=' + this.data.email[0];//1st letter
                this.dom.btnTop.src = avatarSrc;
                this.dom.drawerAvatar.src = avatarSrc;
                this.dom.avatar.src = avatarSrc;
                this.dom.btnTop.title = 'Signed in as: ' + this.data.email;
                this.dom.btnTop.alt = 'Signed in as: ' + this.data.email;
                this.dom.drawerAvatar.title = 'Signed in as: ' + this.data.email;
                this.dom.drawerAvatar.alt = 'Signed in as: ' + this.data.email;
                this.dom.txtAccountDrawer.textContent = 'My Account';
                this.dom.email.textContent = this.data.email;
                this.dom.stats.textContent = (this.purchaseRewarded ? 'Ad-supported ' : '') +
                    (PLANS[this.currentPlan].name) + ' Plan';

                this.dom.accPrefsContainer.querySelector('.chk-email-renewal-reminders input').checked = this.data.email_renewal_reminders == 1;
                this.dom.accPrefsContainer.querySelector('.chk-email-discounts input').checked = this.data.email_discounts == 1;
                this.dom.accPrefsContainer.style.display = '';

                if (data.active_sessions_cnt > 1) {
                    this.dom.otherSessContainer.style.display = '';
                    this.dom.txtOtherSess.textContent = (data.active_sessions_cnt-1) + ' other ' + (data.active_sessions_cnt==2 ? 'device/browser' : 'devices/browsers');
                }

                this.dom.referralsContainer.style.display = '';
                if (this.data.referral_code) {
                    this.dom.btnReferral.style.display = 'none';
                    this.dom.boxReferral.style.display = '';
                    this.dom.linkReferral.textContent =
                        typeof referrals !== 'undefined' ?
                        referrals.getLink() : 'Loading...';
                } else {
                    this.dom.boxReferral.style.display = 'none';
                    this.dom.btnReferral.style.display = '';
                    this.dom.btnReferral.textContent = 'I AGREE, GENERATE MY LINK';
                    this.dom.btnReferral.disabled = false;
                }

                this.dom.purchasesContainer.style.display = '';
                this._fillPurchases();
                if (this.purchases.length) {
                    this.dom.noPurchases.style.display = 'none';
                    this.dom.purchases.style.display = '';
                    document.querySelector('#renew').style.display = this.activePurchase ? 'none' : '';
                } else {
                    this.dom.noPurchases.style.display = '';
                    this.dom.purchases.style.display = 'none';
                }

                if (this._hasPaidPurchases()) {
                    this.dom.btnManagePayments.style.display = '';
                    this.dom.txtManageStripe.textContent =
                        this.purchases.find(p => p.active && p.subscription) ?
                        'SUBSCRIPTION' : 'PAYMENTS';
                }

                if (this.data.billing_needs_action > 0) {
                    this.dom.btnManagePayments.classList.add('raised');
                    if (!location.hash) {
                        window.loadingStateDialog = 'actionRequired';
                        window.location = '#actionRequired';
                    }
                }

                //cookiesUse.close();

                _paq.push(['setUserId', this.data.id]);
            } else {
                this.dom.btnTop.src = ROOT_FOLDER + '/img/avatar.webp';
                this.dom.drawerAvatar.src = ROOT_FOLDER + '/img/avatar.webp';
                this.dom.avatar.src = ROOT_FOLDER + '/img/avatar.webp';
                this.dom.btnTop.title = 'Sign in';
                this.dom.btnTop.alt = 'Sign in';
                this.dom.drawerAvatar.title = 'Sign in';
                this.dom.drawerAvatar.alt = 'Sign in';
                this.dom.txtAccountDrawer.textContent = 'Sign In';
                this.dom.email.textContent = 'Not logged in';
                this.dom.stats.textContent = 'Free Plan';
                this.dom.accPrefsContainer.style.display = 'none';
                this.dom.otherSessContainer.style.display = 'none';
                this.dom.referralsContainer.style.display = 'none';
                this.dom.purchasesContainer.style.display = 'none';
                this.dom.btnManagePayments.style.display = 'none';
                this.dom.btnManagePayments.classList.remove('raised');

                _paq.push(['resetUserId']);
            }

            //Redo checks if files are already selected:
            if (typeof convertList !== 'undefined') {
                convertList.triggerAd();
                if(this.activePurchase) convertList.refillIfNeeded();
            }
            
            this.dom.btnUpgradeTop.style.display = this.activePurchase ? 'none' : '';
            this.dom.linkUpgradeMobile.style.display = this.currentPlan == 'pro' ? 'none' : '';

            if(!this.activePurchase) setOrigNamesOption(false);

            this._schedulePurchaseExpiration();

            this.dom.btnTop.style.display = '';

            if(wasLoggedIn === false && this.loggedIn) credMan.offerSave();

            _paq.push(['setCustomDimension', 7, this.currentPlan]);
        })
        .catch(err => {
            if (attemptCnt < 2) {
                setTimeout(() => {
                    this.checkLoginState(queryParams, attemptCnt + 1);
                }, 1000);
            } else {
                console.error(err);
                //Sentry.captureException(err);

                this.fetchFailed = true;
                window.dispatchEvent(new CustomEvent('login-state-changed'));//to fire queued onLoginStateFetched tasks

                toast.show("Failed to fetch account info. Some features may not work.", 10000, "RETRY", function () {
                    toast.hide();
                    account.checkLoginState();
                });
            }
        });
    },
    syncOtherTabs: function () {
        this.bc && this.bc.postMessage('check-login-state');
    },
    _checkForMsgs: function () {
        var url = new URL(location);
        this.showMsg(url.searchParams.get('login_msg'));
        if (url.searchParams.has('login_msg')) {
            url.searchParams.delete('login_msg');
            history.replaceState(null, null, url);
        }
    },
    showMsg: function (tag) {
        switch (tag) {
            case 'ok':
                this.onLoginStateFetched(() => {
                    if (this.loggedIn) {
                        toast.show("Signed in as: " + this.data.email, 5000, "OK", function () {
                            toast.hide();
                        });
                        if(this.activePurchase) setOrigNamesOption(true);
                    }
                });
                break;
            case 'generic_error':
                toast.show("Sign-in error. Try with another login method.", 5000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'state':
                toast.show("Sign-in error: invalid state.", 5000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'id_token':
                toast.show("Sign-in error: could not verify token.", 5000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'missing_email':
                toast.show("Sign-in error: no email found. Use an account with an email address.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'denied_email':
                toast.show("Sign-in error: email permission denied. Please allow access to your email address.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'hidden_email':
                toast.show("Sign-in error: email hidden. Please share your email to avoid losing account access.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'unverified_email':
                toast.show("Sign-in error: email not verified. Please verify your email.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'code_expired':
                toast.show("Sign-in error: this code has expired.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'code_incorrect':
                toast.show("Sign-in error: incorrect verification code.", 10000, "TRY AGAIN", function () {
                    account.login();
                    toast.hide();
                });
                break;
            case 'banned':
                toast.show("Your account has been banned.", 5000, "OK", function () {
                    toast.hide();
                });
                break;
        }
    },
    onLoginStateFetched: function (fn, includeFailed = false) {
        if (this.loggedIn != null || (includeFailed && this.fetchFailed)) {
            fn && fn();
        } else {
            //Initial request has not completed yet:
            window.addEventListener('login-state-changed', () => {
                this.onLoginStateFetched(fn, includeFailed);
            }, { once: true });
        }
    },
    btnClicked: function () {
        this.onLoginStateFetched(() => {
            this.loggedIn ? location.href = '#account' : this.login();
        });
    },
    login: function (autofill, useRedirect) {
        var url = new URL(ACC_DOMAIN + '/');
        if (autofill) {
            //Don't go through the ACC_DOMAIN homepage first, directly log in:
            url.pathname += 'login_' + this.providers[autofill.provider] + '.php';
            url.searchParams.set('email', autofill.id);
        }

        if (useRedirect || !pups.open(url, 'login', 500)) {
            //Redirection fallback:
            storage.set('session', 'prevent_unload', 0);
            url.searchParams.set('return_to', location.href);
            location.href = url;
        }
    },
    logout: function (btn) {
        btn.disabled = true;

        fetch(ROOT_FOLDER + '/cf_nocache/ajax/logout.php')
        .then(response => {
            if(response.ok) return response.json();
            throw Error('Server returned status code ' + response.status);
        })
        .then(data => {
            this.checkLoginState();
            this.syncOtherTabs();

            btn.disabled = false;
            hideDialog('account');
            toast.show("You were logged out.", 4000, "OK", function () {
                toast.hide();
            });
        })
        .catch(err => {
            setTimeout(() => {
                this.logout(btn);
            }, 1000);
            
            console.error(err);
            //Sentry.captureException(err);
        });

        credMan.pauseAutoLogin();
    },
    logoutOtherSess: function (btn) {
        btn.disabled = true;
        btn.textContent = 'Logging out...';

        fetch(ROOT_FOLDER + '/cf_nocache/ajax/active_sessions.php?logout=1')
        .then(response => {
            if(response.ok) return response.json();
            throw Error('Server returned status code ' + response.status);
        })
        .then(data => {
            this.dom.otherSessContainer.style.display = 'none';
            hideDialog('account');
            toast.show("You were logged out from all other devices/browsers.", 5000, "OK", function () {
                toast.hide();
            });
        })
        .catch(err => {
            setTimeout(() => {
                this.logoutOtherSess(btn);
            }, 1000);
            
            console.error(err);
            //Sentry.captureException(err);
        });
    },

    _hasPaidPurchases: function () {
        return this.purchases.some(p => ['stripe', 'paypro', 'gplay'].includes(p.payment_provider));
    },
    managePayments: function (flow = '', price = '', plan = '', period = '') {
        var url = ACC_DOMAIN + '/manage_payments.php?flow=' + flow + '&new_price=' + price
            + '&gtag_plan=' + plan + '&gtag_period=' + period;
        if (!pups.open(url, 'customer_portal', 600)) {
            //Redirection fallback:
            storage.set('session', 'prevent_unload', 0);
            location.href = url;
        }
    },

    setEmailPrefs: function (changes) {
        let params = new URLSearchParams();
        for (const [key, val] of Object.entries(changes))
            params.set(key, val);
        
        fetch(ROOT_FOLDER + '/cf_nocache/ajax/set_acc_pref.php?' + params)
        .then(response => {
            if (response.ok)
                toast.show('Email preferences saved.', 4000, "OK", function () {
                    toast.hide();
                });
            else
                throw Error('Server returned status code ' + response.status);
        })
        .catch(err => {
            console.error(err);
            Sentry.captureException(err);

            toast.show('Failed to save email preferences. Try again later.', 5000, "OK", function () {
                toast.hide();
            });
        });
    },

    _fillPurchases: function () {
        this.dom.purchasesList.textContent = '';//Empty it out

        this.purchases.forEach(p => {
            var item = this.dom.purchaseTemplate.content.cloneNode(true);
            item.querySelector('.purchased-item-name').textContent = p.name + ' ' + p.duration_human;
            item.querySelector('.purchased-item-start').textContent = 'From: ' + utils.unixToDateTime(p.date_paid);
            item.querySelector('.purchased-item-end').textContent = 'Until: ' + utils.unixToDateTime(p.date_expires);
            item.querySelector('.purchased-item-status').textContent = p.status;

            var statusEl = item.querySelector('.purchased-item-status');
            if (p.active && p.subscription) {
                statusEl.onclick = account.managePayments;
                statusEl.style.textDecoration = 'underline';
                statusEl.style.cursor = 'pointer';
            }
            if(p.active) statusEl.style.color = 'var(--primary-color-light)';

            if (p.receipt) {
                var receiptEl = item.querySelector('.purchased-item-receipt');
                //Support middle-click to open in new tab:
                receiptEl.href = ACC_DOMAIN + '/see_receipt.php?purchase_id=' + p.id;
                //Better UX on mobile installed PWA:
                receiptEl.addEventListener('click', e => pups.open(e.currentTarget.href, 'receipt', 660) && e.preventDefault());
                receiptEl.style.display = '';
            }

            this.dom.purchasesList.appendChild(item);
        });
    },

    _schedulePurchaseExpiration: function () {
        if (this._purchaseExpiresCheck) {
            clearTimeout(this._purchaseExpiresCheck);
            this._purchaseExpiresCheck = null;
        }

        if (this.activePurchase) {
            var expiresAfter = this.activePurchase.date_expires * 1000 - Date.now();//in ms
            //Don't set checker if in leeway period or if it's too far in the future:
            if (expiresAfter > 0 && expiresAfter < 86400000)
                this._purchaseExpiresCheck = setTimeout(() => {
                    this.checkLoginState();
                }, expiresAfter);
        }
    },

    _detectReferral: function () {
        var referral = new URL(location).searchParams.get('r');
        var regex = /^[A-Za-z0-9]{6}$/;//sanitize cookie value
        if(!regex.test(referral)) return;

        document.cookie = 'from_referral=' + referral + '; Path=/; ' +
            'Domain=' + COOKIE_DOMAIN + '; Max-Age=86400; ' +
            (location.protocol == 'https:' ? 'Secure; ' : '') +
            'SameSite=Lax';
        logEvt('from_referral', { 'event_category': 'referral_program', 'event_label': referral });
    }
};


document.addEventListener('DOMContentLoaded', function() {
    account.init();
});//For communication with the cross-origin "account" subdomain

window.addEventListener('message', e => {
    if(e.origin !== new URL(ACC_DOMAIN).origin) return;
    if(!e.data.action) return;

    var bill = {};
    if (e.data.priceId && e.data.processor && 'getPriceDataById' in upgrade)
        bill = upgrade.getPriceDataById(e.data.priceId, e.data.processor);

    // e.source is popup
    // e.data is the sent data
    switch (e.data.action) {
        case 'close_popup':
            window.addEventListener('login-state-changed', () => {
                account.showMsg(e.data.toastMsg);
                e.source.close();
                
                if (e.data.toastMsg == 'ok')
                    accountGoals.checkToComplete();
            }, { once: true });
            account.checkLoginState();
            account.syncOtherTabs();
            break;
        case 'to_payment_form':
            logEvt('payment_form_view', {
                'event_category': 'premium',
                'event_label': e.data.processor + '; ' + e.data.gtagPlan
                    + '; ' + e.data.gtagPeriod,
                'value': bill.price,
                'currency': bill.currency
            }, { dimension8: upgrade.defaultFrequency, dimension9: bill.currency });
            break;
        case 'cancelled':
            account.checkLoginState();
            logEvt('payment_cancel', {
                'event_category': 'premium',
                'event_label': e.data.processor + '; ' + e.data.gtagPlan
                    + '; ' + e.data.gtagPeriod,
                'value': bill.price,
                'currency': bill.currency
            }, { dimension8: upgrade.defaultFrequency, dimension9: bill.currency });
            break;
        case 'paid':
            window.upgradeType = e.data.processor == 'paypro' ? 'slowPayment' : 'payment';
            location.hash = '#verifyUpgrade';
            logEvt('payment_complete', {
                'event_category': 'premium',
                'event_label': e.data.processor + '; ' + e.data.gtagPlan
                    + '; ' + e.data.gtagPeriod,
                'value': bill.price,
                'currency': bill.currency
            }, { dimension8: upgrade.defaultFrequency, dimension9: bill.currency });
            if (window.uet)
                uet.trackGoal(
                    e.data.gtagPeriod == 'one-time' ? 'inapp_purchase' : 'inapp_subscribe',
                    e.data.gtagPlan,
                    e.data.processor,
                    bill.price,
                    bill.currency
                );
            break;
        case 'already_paid_same':
        case 'already_subscribed':
            window.addEventListener('login-state-changed', () => {
                location.hash = '#account';
                e.source.close();
            }, { once: true });
            account.checkLoginState();
            break;
        case 'payment_action_required':
            window.loadingStateDialog = 'actionRequired';
            window.location = '#actionRequired';
            break;
        case 'close_portal':
            if(location.hash == '#actionRequired') hideDialog('actionRequired');
            if (e.data.flow == 'subscription_update_confirm') {
                window.upgradeType = 'payment';
                location.hash = '#verifyUpgrade';
                logEvt('plan_switch_complete', {
                    'event_category': 'premium',
                    'event_label': 'stripe; ' + e.data.gtagPlan
                        + '; ' + e.data.gtagPeriod,
                    'value': bill.price,
                    'currency': bill.currency
                }, { dimension8: upgrade.defaultFrequency, dimension9: bill.currency });
            }
            account.checkLoginState();
            break;
        case 'force_reload':
            storage.set('session', 'prevent_unload', 0);
            location.reload();
            break;
    }
});//Goals waiting to complete upon signup/login
var accountGoals = {
    list: [],
    checkToComplete: function () {
        this.list.forEach((goal, idx) => {
            switch (goal) {
                case 'vpn':
                    logEvt('vpn_forced_login_complete', {
                        'event_category': 'vpn',
                        'event_label': 'Login completed to convert with VPN'
                    });
                    break;
            }

            //Ensure the goal will be executed only once:
            this.list.splice(idx, 1);
        });
    }
};var credMan = {
    offerSave: function () {
        if(!window.FederatedCredential) return;

        var oauthProvider = this._getUsedProvider();
        if(!oauthProvider) return;//logged in via email code

        account.onLoginStateFetched(() => {
            if (account.loggedIn) {
                var cred = new FederatedCredential({
                    id: account.data.email,
                    provider: 'https://' + oauthProvider,
                    iconURL: account.data.avatar
                });
                navigator.credentials.store(cred)
                .catch(this._handleError);
            }
        });
    },
    autoLogin: function () {
        account.onLoginStateFetched(() => {
            if(!window.FederatedCredential || account.loggedIn) return;

            navigator.credentials.get({
                mediation: 'silent',
                federated: {
                    providers: Object.keys(account.providers)
                }
            })
            .then(cred => {
                if(!cred) return;
        
                logEvt('auto_login_silent', {
                    'event_category': 'credential_management',
                    'event_label': 'Silently logging in user'
                });
                account.login(cred, true);
            })
            .catch(this._handleError);
        });
    },
    pauseAutoLogin: function () {
        if (window.FederatedCredential && navigator.credentials?.preventSilentAccess)
            navigator.credentials.preventSilentAccess()
            .catch(this._handleError);
    },
    _getUsedProvider: function () {
        return document.cookie
            .split('; ')
            .find(row => row.startsWith('oauth_provider='))
            ?.split('=')[1];
    },
    _handleError: function (err) {
        console.error(err);
        //Android WebView - "The user agent does not support public key credentials":
        if(err?.name === 'NotSupportedError') return;//not a real problem

        Sentry.captureException(err);
    }
};


document.addEventListener('DOMContentLoaded', function() {
    credMan.autoLogin();
});var notifs = {
    _history: [], /* for clearing shown notifications in Safari (old API) */

    allowed: function () {
        return !!window.Notification && Notification.permission === 'granted';
    },
    _useSW: async function () {
        if (!('serviceWorker' in navigator)) return false;//Firefox InPrivate

        var registration = await navigator.serviceWorker.ready;
        return 'getNotifications' in registration;//false for older desktop Safari
    },

    pushConvStatus: async function (type, convCnt) {
        if (!this.allowed() || storage.get('local', 'notifications') !== 'checked')
            return;

        if (type == 0) {
            var title = 'Converting...';
            var options = {
                body: '',
                silent: true,
                tag: 'conversion-progress',
                icon: ROOT_FOLDER + '/img/notifications/progress.webp',
                actions: [{
                    action: 'cancel',
                    title: 'Cancel' + (convCnt.progress > 1 ? ' All' :''),
                    icon: ROOT_FOLDER + '/img/notifications/cancel.webp'
                }]
            };
            options.body += convCnt.progress + ' conversion' + (convCnt.progress > 1 ? 's' : '') + ' in progress';
            if (convCnt.done)
                options.body += '\n' + convCnt.done + ' conversion' + (convCnt.done > 1 ? 's' : '') + ' complete';
        } else {
            this.clear('conversion-progress');
            if(!convCnt.done) return;//all cancelled/errored

            var title = 'Finished converting';
            var options = {
                body: convCnt.done + ' item' + (convCnt.done > 1 ? 's are' : ' is') + ' ready for download',
                tag: 'conversion-done',
                icon: ROOT_FOLDER + '/img/notifications/done' + (convCnt.done > 1 ? '-all' :'') + '.webp',
                actions: [{
                    action: 'download',
                    title: 'Download' + (convCnt.done > 1 ? ' All' :''),
                    icon: ROOT_FOLDER + '/img/notifications/download.webp'
                }]
            };
        }
        options.badge = options.icon;//for Android notification bar

        if (await this._useSW()) {
            var registration = await navigator.serviceWorker.ready;
            registration.showNotification(title, options);
        } else {
            //Use old Notification API:
            delete options.actions;//not supported on Safari desktop
            this._history.push(new Notification(title, options));
        }
    },

    /* Pass null tag to clear all: */
    clear: async function (tag) {
        if (!this.allowed()) return;

        var notifications = this._history;
        if (await this._useSW()) {
            //Newer notifications via service worker supported:
            var registration = await navigator.serviceWorker.ready;
            notifications = await registration.getNotifications();
        }

        notifications.forEach(notification => {
            if (!tag || notification.tag === tag)
                notification.close();
        });
    }
};//Animate when in view:
var firstRun = true;
var animObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !firstRun && !document.body.classList.contains('reduced-motion'))
            entry.target.classList.add('in-view');
    });
    firstRun = false;
});
document.querySelectorAll('.animate-in-view > *').forEach(el => {
    animObserver.observe(el);
});

//Log event when in view:
var logEvtObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            logEvt('scroll_to', {
                'event_category': entry.target.dataset.logEvtCategory,
                'event_label': entry.target.id
            });
            logEvtObserver.unobserve(entry.target);
        }
    });
});
document.querySelectorAll('.log-evt-in-view').forEach(el => {
    logEvtObserver.observe(el);
});var pwaPrompt = {
    dom: {
        linkDrawer: document.querySelector('#linkInstall'),
        linkWide: document.querySelector('#linkInstallWide'),
        txtShareTarget: document.querySelector('#txtShareTarget')
    },
    evt: null,
    onBeforeInstallPrompt: function (e) {
        if (storage.get('session', 'pwa_prompt_dimissed')) return;//show once per session
        if (storage.get('session', 'twa') == 'mswin') return;//fix for Windows Store PWA
        //Prevent default Android Chrome install banner from showing:
        e.preventDefault();
        //Stash the event so it can be triggered later:
        this.evt = e;
        this.dom.linkDrawer.style.display = '';
        this.dom.linkWide.style.display = '';
        //Only show the Share Target hint on Android, since it's the only supported platform for now:
        if (navigator.userAgent.indexOf("Android") == -1)
            this.dom.txtShareTarget.style.display = 'none';
    },
    install: function () {
        if (!this.evt) return;

        this.evt.prompt();
        //Wait for the user to respond to the prompt:
        this.evt.userChoice.then(choice => {
            logEvt('pwa_install_prompt', { 'event_category': 'pwa', 'event_label': 'Prompt ' + choice.outcome });
            this.dom.linkDrawer.style.display = 'none';
            this.dom.linkWide.style.display = 'none';
            if (choice.outcome == 'dismissed')
                storage.set('session', 'pwa_prompt_dimissed', 1);
            //Clear the saved prompt since it can't be used again:
            this.evt = null;
        });
    },

    webkit: {
        webcomponent: null,/* DOM elemenent */
        init: function () {
            if(!browserCompat.isWebkit()) return;
            if(!storage.get('local', 'pwa_webkit_prompt')) return;

            loadScript(ROOT_FOLDER + '/js/bundle/pwa-install.bundle.js', () => {}, 'module');
            this.webcomponent = document.getElementsByTagName('pwa-install')[0];

            this.webcomponent.addEventListener('pwa-install-how-to-event', this.onHowTo);
            this.webcomponent.addEventListener('pwa-install-gallery-event', this.onGallery);
            this.webcomponent.addEventListener('pwa-user-choice-result-event', this.onChoice);
        },
        onHowTo: function (e) {
            logEvt('pwa_webkit_instructions', {
                'event_category': 'pwa',
                'event_label': e.detail.message
            });
        },
        onGallery: function (e) {
            logEvt('pwa_webkit_gallery_view', {
                'event_category': 'pwa',
                'event_label': e.detail.message
            });
        },
        onChoice: function (e) {
            //Currently, e.detail.message is `dismissed` only
            logEvt('pwa_webkit_install_prompt', {
                'event_category': 'pwa',
                'event_label': 'Webkit prompt ' + e.detail.message
            });
        }
    }
};

window.addEventListener(
    'beforeinstallprompt',
    pwaPrompt.onBeforeInstallPrompt.bind(pwaPrompt),
    { once: true }
);

document.addEventListener('DOMContentLoaded', function() {
    pwaPrompt.webkit.init();
});var contact = {
    dom: {},
    init: async function () {
        this.dom.link = document.querySelector('#linkContact');
        
        var uaDataStr = null;
        if (navigator?.userAgentData?.getHighEntropyValues)
            uaDataStr = JSON.stringify(
                await navigator.userAgentData.getHighEntropyValues([
                    'platformVersion', 'model'
                ])
            );

        //Build the params with debug info for the contact form:
        var params = new URLSearchParams({
            user_agent_legacy: navigator.userAgent,
            user_agent_data: uaDataStr,
            from_url: location.href,
            from_packaged_app_store: storage.get('session', 'twa'),
            from_browser_extension: storage.get('session', 'ext')
        });

        //Faster, without waiting for the login state or Matomo:
        this.setParams(params);

        //On page load:
        account.onLoginStateFetched(() => {
            this._updateEmail(params);
        });
        //Later logins:
        window.addEventListener('login-state-changed', () => {
            this._updateEmail(params);
        });

        //Async Matomo:
        _paq.push([function () {
            contact._updateMatomo(params, this.getVisitorId());
        }]);
    },
    setParams: function (params) {
        var url = new URL(this.dom.link.href);
        url.search = params;
        this.dom.link.href = url;
    },
    openWith: function (additionalParams) {
        var url = new URL(this.dom.link.href);
        for (const key in additionalParams)
            url.searchParams.append(key, additionalParams[key]);
        window.open(url);
    },

    _updateEmail: function (params) {
        if (account.loggedIn)
            params.set('email', account.data.email);
        else
            params.delete('email');

        this.setParams(params);
    },
    _updateMatomo: function (params, visitorId) {
        if (visitorId)
            params.set('mtm_visitor_id', visitorId);

        this.setParams(params);
    }
};


document.addEventListener('DOMContentLoaded', function() {
    contact.init();
});var dragdrop = {
    dom: {},
    init: function () {
        this.dom = {
            dropArea: document.querySelector('#dropArea'),
            filePicker: document.querySelector('#filePicker'),
            folderPicker: document.querySelector('#folderPicker'),
            card: document.querySelector('#filesDropCard'),
            btnAndroidGDrivePicker: document.querySelector('#btnAndroidGDrivePicker'),
            btnWebGDrivePicker: document.querySelector('#btnWebGDrivePicker'),
            btnUseLegacyPicker: document.querySelector('#btnUseLegacyPicker')
        };

        this.enable();

        //Workaround detection for clicking Cancel on the file picker:
        window.addEventListener('focus', function () {
            this.fileOut();
        }.bind(this));

        if (browserCompat.isDirectoryPickerSupported())
            document.querySelector('#btnPickFolder').style.display = '';
        if (browserCompat.isAndroidGDrive()) {
            this.dom.btnAndroidGDrivePicker.style.display = '';
            this.dom.btnWebGDrivePicker.style.display = 'none';
        }
    },

    enable: function () {
        document.body.ondragenter = this.fileIn.bind(this);
        document.body.ondragover = e => e.preventDefault();
        document.body.ondragleave = this.fileOut.bind(this);
        document.body.ondrop = this.fileDropped.bind(this);
    },
    disable: function () {
        document.body.ondragenter = null;
        document.body.ondragover = null;
        document.body.ondragleave = null;
        document.body.ondrop = null;
    },
    
    fileIn: function (e) {
        if (e) {
            e.preventDefault();
            //Prevent firing when moving between children:
            document.body.classList.add('drag-dropping');
        }
        if(!Object.keys(this.dom).length) return;//user clicked before DOM fully loaded
        if (typeof convertList === 'undefined') {
            //Main drag&drop card
            this.dom.dropArea.classList.add('highlighted');
            this.dom.card.classList.add('raised-card');
        } else {
            //Drop more card
            convertList.dom.card.classList.add('dropping-more');
        }
        //User intent to convert, preload svg icons:
        loadScript(ROOT_FOLDER + '/js/userFriendly.js');
    },
    fileOut: function (e) {
        if (e) {
            e.preventDefault();
            //Prevent firing when moving between children:
            if (e.target.tagName.toLowerCase() != 'body' && !document.querySelector('dialog[open]'))
                return;
            document.body.classList.remove('drag-dropping');
        }
        if (typeof convertList === 'undefined') {
            //Main drag&drop card
            this.dom.dropArea.classList.remove('highlighted');
            this.dom.card.classList.remove('raised-card');

            if (!this._hasShownUnableSelect && navigator.userAgent.match(/Android/i)) {
                //Some Android browsers (DDG, GoogleGo) have bugs with accept/multiple attributes
                //Show btn to try again without those attributes:
                setTimeout(function () {
                    if (typeof convertList === 'undefined') {
                        this._hasShownUnableSelect = true;
                        this.dom.btnUseLegacyPicker.style.display = '';
                    }
                }.bind(this), 700);
            }
        } else {
            //Drop more card
            convertList.dom.card.classList.remove('dropping-more');
        }
    },
    fileDropped: function (e) {
        this.fileOut(e);
        if (e.dataTransfer.files.length == 0) {
            toast.show('Please select files and folders only.', 5000, 'OK', function () {
                toast.hide();
            });
            return;
        }

        this.dom.card.style.animationName = 'fade-slide-out';//Needed if Promise takes a long time
        folders.getAllFiles(e.dataTransfer.items).then(files => {
            this.handleFiles(files, 'file_dropped', 'File drag-and-dropped');
        });
    },
    handleFiles: function (files, evtAction, evtLabel) {
        if (!files.length) {
            toast.show('No files could be added. Try selecting files in another way.', 5000, 'OK', function () {
                toast.hide();
            });
            this.dom.card.style.animationName = '';
            return;
        }

        pwaPrompt.webkit.webcomponent?.hideDialog?.();
        document.querySelectorAll('.description').forEach(function (el) {
            el.style.opacity = '0';
        });
        this.dom.card.style.animationName = 'fade-slide-out';//Needed again for onchange

        logEvt(evtAction, {
            'event_category': 'file_selection',
            'event_label': evtLabel,
            'value': files.length
        });

        //For the workaround, setTimeout/loadScript must NOT be called before the cloning:
        if (evtAction == 'file_picked_gdrive_android')
            this._getClone(files).then(clonedFiles => this._handleFiles(clonedFiles));
        else
            this._handleFiles(files);
    },
    _handleFiles: function (files) {
        loadScript(ROOT_FOLDER + '/js/userFriendly.js', function () {
            setTimeout(function () {
                this.dom.card.style.display = 'none';
                document.querySelectorAll('.description').forEach(function (el) {
                    el.style.display = 'none';
                });
                loadScript(ROOT_FOLDER + '/js/targetFormats.js', function () {
                    targetFormats.init();
                    targetFormats.dom.card.style.display = '';
                });
            }.bind(this), document.body.classList.contains('reduced-motion') ? 0 : 400);
        
            setTimeout(function () {
                loadScript(ROOT_FOLDER + '/js/convertList.js', function () {
                    convertList.init();
                    convertList.fillFilesList(files);
                });
            }.bind(this), typeof convertList !== 'undefined' ? 0 : document.body.classList.contains('reduced-motion') ? 10 : 800);
        }.bind(this));
    },

    tryCompatFileSelect: function () {
        this.dom.filePicker.setAttribute('accept', '*/*');
        this.dom.filePicker.removeAttribute('multiple');
        this.dom.filePicker.dataset.eventAction = '_legacy';//for gtag
        this.dom.filePicker.dataset.eventLabel = '(legacy Android)';
        this.dom.btnUseLegacyPicker.style.display = 'none';
        document.querySelector('.mobile.smallest').textContent = 'Select multiple files one by one';
        toast.show('Trying with the legacy file picker...', 2000);
        setTimeout(function () {
            this.dom.filePicker.click();
        }.bind(this), 250);
    },

    selectAndroidGDrive: function () {
        //Show tutorial first:
        if (storage.get('local', 'hide_tut_gdrive') != 'true')
            location.hash = '#gdriveAndroid';
        else if (storage.get('local', 'prefer_gdrive_type') == 'android')
            this.openAndroidGDrive();
        else
            this.dom.btnWebGDrivePicker.click();
    },
    openAndroidGDrive: function () {
        this.dom.filePicker.dataset.eventAction = '_gdrive_android';//for gtag and to trigger the GDrive Workaround
        this.dom.filePicker.dataset.eventLabel = '(Android GDrive Workaround)';
        storage.set('local', 'prefer_gdrive_type', 'android');
        toast.show('Selecting from Google Drive...', 2000);
        setTimeout(function () {
            this.dom.filePicker.click();
        }.bind(this), 250);
    },
    _getClone: async function (files) {
        var clone = [];
        for (var i = 0; i < files.length; i++) {
            var clonedFile = new File(
                [await files[i].arrayBuffer()], files[i].name,
                { type: files[i].type, lastModified: files[i].lastModified }
            );
            clone.push(clonedFile);
        }
        return clone;
    }
};

//Credits: https://stackoverflow.com/a/53058574
var folders = {
    /* Returns all files from all folders: */
    getAllFiles: async function (dataTransferItemList) {
        let files = [];
        let queue = [];
        for (let i = 0; i < dataTransferItemList.length; i++)
            queue.push(dataTransferItemList[i].webkitGetAsEntry() || dataTransferItemList[i].getAsFile());
        //webkitGetAsEntry() may be null sometimes:
        //1. When pasting image from clipboard (e.g. from snipping tool)
        //2. Drag and drop on ChromeOS
        //In those cases, get the File directly.
        while (queue.length > 0) {
            let entry = queue.shift();
            if (!entry)
                console.error('Both webkitGetAsEntry() and getAsFile() returned null');
            else if (entry instanceof File)
                files.push(entry);
            else if (entry.isFile)
                files.push(await this._getFile(entry));
            else if (entry.isDirectory)
                queue.push(...await this._readAllDirectoryEntries(entry.createReader()));
        }
        return files;
    },
    _readAllDirectoryEntries: async function (directoryReader) {
        let entries = [];
        let readEntries = await this._readEntriesPromise(directoryReader);
        while (readEntries.length > 0) {
            entries.push(...readEntries);
            readEntries = await this._readEntriesPromise(directoryReader);
        }
        return entries;
    },
    /* Since Chrome returns 100 entries at most, go over them all */
    _readEntriesPromise: async function (directoryReader) {
        try {
            return await new Promise((resolve, reject) => {
                directoryReader.readEntries(resolve, reject);
            });
        } catch (err) {
            console.error(err);
        }
    },
    /* Convert from FileEntry to regular File object: */
    _getFile: async function (fileEntry) {
        try {
            return await new Promise((resolve, reject) => fileEntry.file(resolve, reject));
        } catch (err) {
            console.error(err);
        }
    }
};


document.addEventListener('DOMContentLoaded', function() {
    dragdrop.init();
});var paste = {
    keyCombo: (navigator.userAgent.includes('Mac') ? '⌘' : 'Ctrl') + '+V',
    _isListening: false,

    _filePasteListener: function (e) {
        e.preventDefault();
        if (e.clipboardData.files.length > 0) {
            //dragdrop.handleFiles(e.clipboardData.files);//files only
            //Files and folders:
            folders.getAllFiles(e.clipboardData.items).then(files => {
                dragdrop.handleFiles(files, 'file_pasted', 'File pasted from clipboard');
            });
        }
    },

    enableListener: function () {
        if (!this._isListening) {
            document.addEventListener('paste', this._filePasteListener);
            this._isListening = true;
        }
    },
    disableListener: function () {
        document.removeEventListener('paste', this._filePasteListener);
        this._isListening = false;
    },

    /* Paste btn */
    clicked: async function () {
        try {
            let files = [];
            const clipboardItems = await navigator.clipboard.read();
            for (const clipboardItem of clipboardItems) {
                for (let mimeType of clipboardItem.types) {
                    const blob = await clipboardItem.getType(mimeType);
                    let name = mimeType.split('/')[0];

                    //Manually add the file extension to the name when certain,
                    //due to guessFormat.js not working well with some text files:
                    switch (mimeType) {
                        case 'image/png':
                            name += '.png';
                            break;
                        case 'image/svg+xml':
                            name += '.svg';
                            break;
                        case 'text/html':
                            name += '.html';
                            break;
                        case 'text/plain':
                            //It may be sth else.
                            //Make the behavior based on the current page:
                            const md = ['.md', '.markdown,.md'];
                            if (md.includes(dragdrop.dom.filePicker.accept)) {
                                name += '.md';
                                mimeType = 'text/markdown';
                            }
                            //else: no strong preference - will invoke guessFormat.js,
                            //and if nothing is recognized, it'll fall back to TXT
                            break;
                    }

                    const file = new File([blob], name, { type: mimeType });
                    files.push(file);
                }
            }
            if (!files.length)
                throw new Error('No clipboard data in browser-allowed mime types.');
            dragdrop.handleFiles(files, 'file_pasted_btn', 'File pasted from clipboard using Async Clipboard button');
        } catch (err) {
            var txt = 'T';
            if (!browserCompat.isDirectoryPickerSupported())
                txt = 'No files found in the clipboard. If you have a keyboard, t';//mobile
            toast.show(txt + 'ry pasting with the keyboard shortcut: ' + this.keyCombo, 5000, 'OK', () => {
                toast.hide();
            });

            console.error(err);

            logEvt('clipboard_read_error', {
                'event_category': 'async_clipboard',
                'event_label': err
            });
        }
    }
};


document.addEventListener('DOMContentLoaded', function() {
    paste.enableListener();
    document.querySelector('#btnPaste').disabled = false;
    document.querySelector('#txtPasteKeyCombo').textContent = paste.keyCombo;
});document.addEventListener('DOMContentLoaded', function() {
    var url = new URL(location);
    if (url.searchParams.has('ext_format')) {
        toast.show("The format you entered is not recognized.", 5000, "OK", function () {
            toast.hide();
        });
        url.searchParams.delete('ext_format');
        history.replaceState(null, null, url);
    }
});