#account {
    max-width: fit-content;
    color: var(--primary-text-color);
}
#accInfoBox {
    display: flex;
}
#avatar {
    width: 40px;
    height: 40px;
}
.avatar {
    border-radius: 50%;
    background-color: #fff;
    font-size: 0; /* hide alt text when image can't load */
}
#accInfoText {
    padding-left: 18px;
}
#accStats {
    color: var(--secondary-text-color);
}
#noPurchases, #accBtns {
    text-align: center;
}
#accBtns {
    margin-top: 16px;
}

#accPrefs .checkbox-container {
    margin: 8px 0;
}
#accPrefs .checkbox-container:first-of-type {
    margin-top: 16px;
}
#accPrefs .checkbox-container:last-of-type {
    margin-bottom: 16px;
}

#accOtherSess button {
    margin-left: -16px;
}
#otherSessInfo {
    margin-top: 16px;
}

#boxReferral {
    display: flex;
    align-items: center;
    box-shadow: 0 0 0 1px var(--disabled-color);
    border-radius: 3px;
}
#linkReferral {
    flex-grow: 1;
    padding-left: 12px;
}

.section-title {
    color: var(--primary-color-light);
}

#purchases {
    text-align: left;
}
.purchased-item {
    margin: 16px 0;
    display: flex;
}
.purchased-item-left {
    flex-grow: 1;
}
.purchased-item-right {
    margin-left: 16px;

    /* For vertical alignment inside: */
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: space-around;
}
@media (min-width: 440px) {
    .purchased-item-right {
        margin-left: 72px;
    }
}
.purchased-item-start, .purchased-item-end, .purchased-item-status {
    color: var(--secondary-text-color);
    font-size: 14px;
}
.purchased-item-status {
    font-size: 13px;
}
.purchased-item-receipt {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin: -8px;
    padding: 8px;

    fill: var(--secondary-text-color);
    transition: background-color .28s var(--standard-bezier);
}
.purchased-item-receipt:hover, .purchased-item-receipt:focus {
    background-color: rgba(0, 0, 0, .2);
}
#renew {
    display: block;
    text-align: center;
}

#actionRequired {
    max-width: fit-content;
    color: var(--primary-text-color);
}
#actionRequired .button {
    width: 100%;
}/* Samsung Internet mobile - dialog: */
#blockedDl {
    max-width: 710px;
    color: var(--primary-text-color);
}
#samsungIntLogo {
    width: 48px;
    height: 48px;
    display: block;
    margin: auto;
    margin-bottom: 12px;
}
#txtBlockedPermaSolution {
    text-align: center;
}
#horizLine {
    margin: 16px -20px;
    border-top:1px solid var(--secondary-text-color);
}
#txtBlockedTempSolution {
    text-align: center;
}
#btnBlockedContinue, #btnToSettings {
    display: block;
    margin: 0 auto;
}
#btnBlockedContinue {
    margin-top: 16px;
}

/* Chromium desktop - popup: */
#bubBlockedDl {
    position: fixed;
    top: 10px;
    box-shadow: var(--elevation-3);
    z-index: 3;

    animation: slide-in-attention 1s both var(--incoming-bezier);
}
#bubBlockedDl::before {
    content: '';
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid var(--primary-background-color);

    position: absolute;
    top: -10px;
}
#bubBlockedDl svg {
    width: 18px;
    vertical-align: bottom;
}
#bubBlockedDl button {
    display: block;
    margin-left: auto;
    margin-bottom: -8px;
}
#txtChrAutoDl {
    color: var(--primary-text-color);
    fill: var(--primary-text-color);   
}* {
    font-family: 'Roboto', sans-serif;
    outline: 0;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
:root {
    --elevation-1: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
    --elevation-3: 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12), 0 3px 5px -1px rgba(0, 0, 0, 0.4);
    --elevation-5: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.4);

    --standard-bezier: cubic-bezier(.4, 0, .2, 1);
    --incoming-bezier: cubic-bezier(0, 0, .2, 1);

    --dialog-polyfilled-center: translateY(0); /* will be overriden by the polyfill */
}

body {
    --primary-color: #4D8FFE;
    --primary-color-light: #4D8FFE;
    --primary-background-color: #fff;
    --secondary-background-color: #eee;
    --primary-text-color: #000;
    --secondary-text-color: #666;
    --accent-color: #ffbf00;
    --error-color: #DD2C00;
    --disabled-color: #a8a8a8;
    --disabled-fg-color: #a8a8a8;
    --disabled-bg-color: #F5F5F5;

    background: var(--secondary-background-color);
    margin: 0;
}
body.dark {
    --primary-color: #2e5598;
    --primary-color-light: #4D8FFE; /* used for themed text on dark backgrounds */
    --primary-background-color: #212121;
    --secondary-background-color: #000;
    --primary-text-color: #F5F5F5;
    --secondary-text-color: #BDBDBD;
    --accent-color: #ffbf00;
    --error-color: #FF3D00;
    --disabled-color: #424242;
    --disabled-fg-color: #a8a8a8;
    --disabled-bg-color: #424242;

    fill: var(--primary-text-color);
    color: var(--primary-text-color);
}
body.reduced-motion > * {
    animation-duration: .001s !important;
    transition-duration: .001s !important;
}

body:not(.dark) .img-dark {
    display: none;
}
body.dark .img-light {
    display: none;
}

/* Prevent firing when moving between children */
body.drag-dropping::after {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10;
}

a {
    color: var(--primary-color-light);
}

a.not-link {
    color: inherit;
    fill: inherit;
    text-decoration: none;
}

a.underlined-hover {
    position: relative;
}
a.underlined-hover::before {
    content: "";
    position: absolute;
    display: block;
    width: 100%;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: #fff;
    transform: scaleX(0);
    transform-origin: left; /* remove to animate from center */
    transition: transform .3s var(--standard-bezier);
}
a.underlined-hover:hover::before,
a.underlined-hover:focus::before {
    transform: scaleX(1);
}

.disclaimer {
    font-size: small;
    color: var(--secondary-text-color);
}
.disclaimer a {
    color: inherit;
}

#settings {
    max-width: 500px;
}
#settings .checkbox-container {
    margin: 0 0 8px 0;
}
#settings .checkbox-container:last-of-type {
    margin: 0;
}

#terms, #privacy, #refunds, #termsReferral {
    max-width: 800px;
    color: var(--primary-text-color);
}
#legal {
    max-width: fit-content;
}
@media (max-width: 1100px) {
    #legal {
        max-width: 400px;
    }
    #legal .button {
        width: 100%;
    }
}

#icnSet {
    display: none;
}

/* Material Design Card */
.card {
    background: var(--primary-background-color);
    display: block;
    border-radius: 3px;
    padding: 16px;
    margin-bottom: 8px;

    box-shadow: var(--elevation-1);

    transition: box-shadow .28s var(--standard-bezier);
}
.card:hover, .card.raised-card, .card:focus {
    box-shadow: var(--elevation-3);
}
.card > * {
    color: var(--secondary-text-color);
    fill: var(--secondary-text-color);
}
.center-card {
    margin-left: auto;
    margin-right: auto;
}
.wide-card {
    width: calc(100vw - 64px);
    max-width: 800px;
}
@media (max-width: 600px) {
    .wide-card {
        width: calc(100vw - 49px); /* 49px instead of 48 to get rid of Windows scrollbar */
    }
}

/* Material Design Button */
.button {
    padding: 14px;
    border: 0;
    outline: 0;
    user-select: none;
    font-size: medium;
    border-radius: 4px;
    color: var(--primary-color-light);
    fill: var(--primary-color-light);
    cursor: pointer;
    background-color: inherit;

    transition: background-color .28s var(--standard-bezier);
}
.button:focus,
.button:hover {
    background-color: rgba(0, 0, 0, .1);
}
.button:disabled {
    color: var(--disabled-color);
    fill: var(--disabled-color);
    background-color: inherit;
    cursor: default;
}
/* Material Design Button - raised */
.button.raised {
    box-shadow: var(--elevation-1);
    background-color: var(--primary-color);
    color: #fff;
    fill: #fff;

    transition-property: box-shadow;
}
.button.raised:focus,
.button.raised:hover {
    box-shadow: var(--elevation-3);
}
.button.raised:disabled {
    color: var(--disabled-fg-color);
    fill: var(--disabled-fg-color);
    background-color: var(--disabled-bg-color);
    box-shadow: none;
    cursor: default;
}

.button-icon {
    width: 24px;
    vertical-align: middle;
    margin-right: 4px;
}

.icon-only {
    padding: 8px;
    border-radius: 50%;
}
.icon-only .button-icon {
    margin-right: 0;
}

.button.raised:has(.button-label) {
    padding: 8px;
}
.button-label {
    background: #F9A825;
    color: var(--primary-background-color);
    font-weight: bold;
    margin: -8px;
    margin-top: 8px;
    border-radius: 0 0 4px 4px;
}

/* Material Design Toolbar */
.toolbar {
    background: var(--primary-color);
    color: #fff;
    font-size: 20px;
    padding: 20px;

    display: flex;
}
.toolbar-in-card,
.toolbar-in-dialog {
    border-radius: 3px 3px 0 0;
}
.toolbar-in-card {
    margin: -16px -16px 16px -16px;
}
.toolbar-in-dialog {
    margin: -20px;
}
.toolbar-in-dialog,
.toolbar-primary {
    position: sticky;
    top: 0;
    z-index: 2;
    box-shadow: var(--elevation-1);
    margin-bottom: 20px;
}
.toolbar-in-dialog {
    top: -20px;
}
@media (max-height: 350px) {
    .toolbar-in-dialog {
        /* Scrolls with content */
        position: unset;
    }
}
.toolbar-collapsible {
    transition: transform .28s var(--standard-bezier);
}
.toolbar-collapsed {
    transform: translateY(-65px);
}
.toolbar-icon {
    width: 24px;
    height: 24px; /* fix for iOS Safari */
    margin-right: 16px;
    fill: #fff;
    vertical-align: middle;

    flex-shrink: 0;
}
.toolbar-title {
    flex-grow: 1;
}
.truncate {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.toolbar-actions {
    margin: -14px; /* to prevent buttons from expanding the toolbar */

    flex-shrink: 0;
}
.toolbar-actions > * {
    color: #fff;
    fill: #fff;
}
.toolbar-actions > .button:disabled {
    color: var(--disabled-fg-color);
    fill: var(--disabled-fg-color);
}
.toolbar-actions .button-icon {
    margin-top: -2px;
}
.progress-bar.attached-to-toolbar {
    margin: -16px 0px 16px -16px;
    width: calc(100% + 32px);
}
@media (max-width: 600px) {
    .toolbar {
        padding: 16px;
    }
    .toolbar:not(.toolbar-in-dialog) > .toolbar-actions {
        margin: -13px;
    }
}

/* Material Design Dialog - !importants needed for overriding polyfill */
dialog {
    border: 0 !important;
    padding: 20px !important;
    border-radius: 3px !important;
    box-shadow: var(--elevation-5) !important;
    background: var(--primary-background-color) !important;

    scrollbar-width: thin;

    /* Positioning and sizing: */
    position: fixed !important;
    width: -moz-available !important;
    width: -webkit-fill-available !important;
    max-height: calc(100% - 40px) !important;
    overflow-y: auto !important;
}
dialog[open] {
    animation: expand-middle .3s var(--incoming-bezier);
}
dialog::backdrop, dialog + .backdrop {
    background: #000 !important;
    opacity: .6 !important;
}
dialog > div {
    margin: -20px;
    padding: 20px;
}
button::-moz-focus-inner {
    border: 0;
}
.toolbar-in-dialog button {
    border: 0;
    background: none;
    outline: 0;
    cursor: pointer;
    margin: 6px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    padding: 1px 6px;

    transition: background .28s var(--standard-bezier);
}
.toolbar-in-dialog button:hover, .toolbar-in-dialog button:focus {
    background: rgba(0, 0, 0, .1);
}
.dialog-bottom {
    position: sticky;
    bottom: -20px;
    margin: -20px;
    margin-top: 0;
    padding: 4px 0;
    background-color: var(--secondary-background-color);
    box-shadow: 0px 6px 6px 5px var(--disabled-color);
    border-radius: 3px 3px 0 0;

    transform: translateY(100%);
    transition: transform .3s var(--incoming-bezier);
}
.dialog-bottom.ready {
    transform: translateY(0);
}

/* Material Design Dropdown Select */
.select {
    position: relative;
    width: 100%;
    display: inline-block;
    margin-top: 16px;
    padding-bottom: 16px;
}
.select-text {
    position: relative;
    background-color: transparent;
    width: 100%;
    padding: 10px 32px 10px 0;
    font-size: 16px;
    border: none;
    border-radius: 0; /* Safari rounding fix */
    border-bottom: 1px solid #737373;
    color: var(--primary-text-color);
    cursor: pointer;
}
.select-text option {
    background: var(--primary-background-color);
}
/* remove focus */
.select-text:focus {
    outline: none;
}
/* Use custom arrow */
.select .select-text {
    appearance: none;
    -webkit-appearance: none;
}

.select:after {
    position: absolute;
    top: 18px;
    right: 10px;
    /* Styling the down arrow */
    width: 0;
    height: 0;
    padding: 0;
    content: '';
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #737373;
    pointer-events: none;
}
/* label */
.select-label {
    color: #737373;
    font-size: 16px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 0;
    top: 10px;
    transition: .28s var(--standard-bezier) all;
}
/* active state */
.select-text:focus ~ .select-label, .select-text:valid ~ .select-label {
    color: var(--primary-color-light);
    top: -16px;
    transition: .28s var(--standard-bezier) all;
    font-size: 14px;
}
/* bottom bar */
.select-bar {
    position: relative;
    display: block;
    width: 100%;
}
.select-bar:before, .select-bar:after {
    content: '';
    height: 2px;
    width: 0;
    bottom: 0;
    position: absolute;
    background: var(--primary-color-light);
    transition: .28s var(--standard-bezier) all;
}
.select-bar:before {
    left: 50%;
}
.select-bar:after {
    right: 50%;
}
/* active state */
.select-text:focus ~ .select-bar:before, .select-text:focus ~ .select-bar:after {
    width: 50%;
}
/* highlighter */
.select-highlight {
    position: absolute;
    height: 60%;
    width: 100px;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
}


/* Material Design Progress Bar */
.progress-bar {
    position: relative;
    height: 4px;
    display: block;
    width: 100%;
    background-clip: padding-box;
    margin: .5rem 0 1rem 0;
    overflow: hidden;

    transition: opacity .28s var(--standard-bezier);
}
.progress-bar-hidden {
    opacity: 0;
}
.progress-bar .determinate,
.progress-bar .indeterminate,
.progress-bar .indeterminate::after {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--primary-color-light);
}
.progress-bar,
.progress-bar .indeterminate::after {
    background-color: #C9DDFE;
}
.progress-bar .determinate {
    transform-origin: left center;
    transition: transform .3s linear;
    transform: scaleX(0);
}
.progress-bar .indeterminate {
    transform-origin: right center;
    animation: indeterminate-bar 2s linear infinite;
}
.progress-bar .indeterminate::after {
    content: '';
    transform-origin: center center;
    animation: indeterminate-splitter 2s linear infinite;
}
@keyframes indeterminate-bar {
    0% {
        transform: scaleX(1) translateX(-100%);
    }
    50% {
        transform: scaleX(1) translateX(0%);
    }
    75% {
        transform: scaleX(1) translateX(0%);
        animation-timing-function: cubic-bezier(.28,.62,.37,.91);
    }
    100% {
        transform: scaleX(0) translateX(0%);
    }
}
@keyframes indeterminate-splitter {
    0% {
        transform: scaleX(.75) translateX(-125%);
    }
    30% {
        transform: scaleX(.75) translateX(-125%);
        animation-timing-function: cubic-bezier(.42,0,.6,.8);
    }
    90% {
        transform: scaleX(.75) translateX(125%);
    }
    100% {
        transform: scaleX(.75) translateX(125%);
    }
}
.progress-bar.attached-to-toolbar-dialog {
    position: sticky; /* fix for scrolling */
    top: 40px;

    margin: -24px -20px 20px -20px;
    z-index: 2;
    width: auto;
}
@media (max-width: 600px) {
    /* Toolbar is smaller */
    .progress-bar.attached-to-toolbar-dialog {
        top: 32px;
    }
}
@media (max-height: 350px) {
    /* Toolbar scrolls with content */
    .progress-bar.attached-to-toolbar-dialog {
        top: -20px;
    }
}

/* Material Design Chip */
.chip {
    display: inline-block;
    width: fit-content;
    padding: 6px 10px;
    margin: 4px;
    border-radius: 32px;
    cursor: pointer;
    user-select: none;
    background-color: var(--secondary-background-color);

    transition: none .28s var(--standard-bezier);
    transition-property: box-shadow, background-color, color, fill, transform, opacity;
}
.chip:focus, .chip:hover {
    box-shadow: var(--elevation-1);
}
.chip-selected {
    background-color: var(--primary-color);
    color: #fff;
    font-weight: bold;
}
.chip-icon {
    width: 24px;
    height: 24px;
    vertical-align: middle;
    margin-left: -2px;
}

/* Material Design Toast/Snackbar */
#toast {
    z-index: 5;
    position: fixed;
    bottom: 14px;
    left: 14px;
    border-radius: 3px;
    padding: 16px 20px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .26);
    font-size: 14px;
    background-color: #323232;
    color: white;

    transition: none .3s var(--incoming-bezier);
    transition-property: transform, opacity, bottom, left;
}
@media (max-width: 500px) {
    #toast {
        bottom: 0;
        left: 0;
        right: 0;
        border-radius: 0;
    }
}
@media (min-width: 340px) {
    #toast {
        min-width: 288px;
    }
}
#toastBtn {
    float: right;
    padding: 10px;
    margin: -10px;
    margin-left: 20px;
    color: var(--primary-color-light);
    font-weight: 600;
    cursor: pointer;
    border-radius: 4px;

    transition: background-color .28s var(--standard-bezier);
}
#toastBtn:hover, #toastBtn:focus {
    background-color: rgba(255, 255, 255, .1);
}
#toast.toast-hidden {
    transform: translateY(150%);
    opacity: 0;
}

/* Material Design Checkbox */
.checkbox-container {
    display: block;
    width: -moz-fit-content;
    width: fit-content;
    margin: auto;
    cursor: pointer;
    user-select: none;
    color: var(--primary-text-color);
}
.checkbox-container > input[type=checkbox] {
    display: none;
}
.checkbox {
    position: relative;
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid;
    border-radius: 2px;
    overflow: hidden;
    vertical-align: top;
    margin-right: 6px;
    color: var(--secondary-text-color);
}
.checkbox::before {
    position: absolute;
    content: "";
    transform: rotate(45deg);
    display: block;
    margin-top: -4px;
    margin-left: 6px;
    width: 0;
    height: 0;
    box-shadow:
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0 inset;
    animation: checkbox-off .28s forwards linear;
}
input[type=checkbox]:checked + .checkbox {
    color: var(--primary-color-light);
}
input[type=checkbox]:checked + .checkbox::before {
    box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        20px -12px 0 11px;
    animation: checkbox-on .2s forwards linear;
}
.checkbox-container:focus > .checkbox {
    color: var(--primary-color-light);
}
@keyframes checkbox-on {
    0% {
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        15px 2px 0 11px;
    }
    50% {
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        20px 2px 0 11px;
    }
    100% {
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        20px -12px 0 11px;
    }
}
@keyframes checkbox-off {
    0% {
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        20px -12px 0 11px,
        0 0 0 0 inset;
    }
    25% {
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        20px -12px 0 11px,
        0 0 0 0 inset;
    }
    50% {
      transform: rotate(45deg);
      margin-top: -4px;
      margin-left: 6px;
      width: 0px;
      height: 0px;
      box-shadow:
        0 0 0 10px,
        10px -10px 0 10px,
        32px 0px 0 20px,
        0px 32px 0 20px,
        -5px 5px 0 10px,
        15px 2px 0 11px,
        0 0 0 0 inset;
    }
    51% {
      transform: rotate(0deg);
      margin-top: -2px;
      margin-left: -2px;
      width: 20px;
      height: 20px;
      box-shadow:
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0px 0px 0 10px inset;
    }
    100% {
      transform: rotate(0deg);
      margin-top: -2px;
      margin-left: -2px;
      width: 20px;
      height: 20px;
      box-shadow:
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0 0 0 0,
        0px 0px 0 0px inset;
    }
}

/* Material Design Radio Button (not implemented) */
input[type=radio] {
    accent-color: var(--primary-color-light);
    width: 16px;
    height: 16px;
}

/* Material Design Search Input (not fully implemented) */
.input-search {
    border: 0;
    border-bottom: 1px solid #737373;
    -webkit-appearance: none; /* Safari rounding fix */
    border-radius: 0; /* yet another Safari rounding fix */
    color: var(--primary-text-color);
    background: none;
    font-size: 16px;
    margin-top: 16px;
    margin-bottom: 16px;

    display: inline-block;
    padding: 4px 0 4px 29px;

    transition: none .28s var(--standard-bezier);
    transition-property: box-shadow, border-bottom-color;
}
.input-search:focus {
    outline: none; /* some browsers fix */

    box-shadow: 0 1px 0 var(--primary-color-light);
    border-bottom-color: var(--primary-color-light);
}
.input-search::placeholder {
    color: var(--secondary-text-color);
    opacity: 1; /* Firefox */
}
/*.input-search:focus::placeholder {
    color: transparent;
}*/
.ic-search {
    width: 24px;
    height: 24px;

    /* Position inside the input-search: */
    margin-bottom: -8px;
    margin-right: -30px;
}

/* Material Design Stepper - use <ol> */
.stepper-container {
    padding-left: 16px;
    padding-top: 16px;
    margin: 0;

    counter-reset: number;
    list-style-type: none;
}
.stepper-step::before {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--primary-color);
    color: #fff;
    font-size: small;

    counter-increment: number;
    content: counter(number);
}
.step-title {
    display: inline-block;
    padding-left: 14px;
    width: calc(100% - 38px); /* mobile newline fix */
    font-weight: bold;
    color: var(--primary-text-color);
    vertical-align: middle;
}
.step-content {
    padding-left: 26px;
    margin-left: 12px;
    padding-top: 6px;
    margin-top: 6px;
    padding-bottom: 36px;
    margin-bottom: 6px;
    box-shadow: -1px 0 0 rgba(128,128,128,.3);
}
.stepper-step:last-of-type .step-content {
    box-shadow: none;
    padding-bottom: 0;
}


/* Animations */
@keyframes fade-slide-in {
    from { opacity: 0; transform: translateY(30vh); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fade-slide-out {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(30vh); }
}
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes expand-middle {
    from {
        opacity: 0;
        transform: scale(.8) var(--dialog-polyfilled-center);
    }
    to {
        opacity: 1;
        transform: scale(1) var(--dialog-polyfilled-center);
    }
}
@keyframes fade-slide-from-right {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
@keyframes fade-slide-from-top {
    from {
        opacity: 0;
        transform: translateY(-100px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fade-out-shrink-height {
    0% {
        opacity: 1;
    }
    60% {
        opacity: 0;
    }
    100% {
        opacity: 0;
        height: 0;
    }
}
@keyframes fade-slide-in-subtle {
    from { opacity: 0; transform: translateY(50%); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slide-in-attention {
    0% { opacity: 0; transform: translateY(50vh); }
    50% { opacity: 1; }
    100% { transform: translateY(0); }
}.section-heading {
    margin-top: 30px;
    margin-bottom: 5px;
    padding-left: 12px;
    padding-right: 12px;
    border-bottom: 1px solid #e0e0e0;
    font-size: xx-large;
    font-weight: normal;
    text-align: center;
}
@media (max-width: 600px) {
    .section-heading {
        font-size: x-large;
    }
}

#formatsInfo > .card {
    display: inline-block;
    max-width: 500px;
    width: calc(100vw - 57px); /* 57px instead of 48 to get rid of Windows scrollbar */
    margin: 4px;
    vertical-align: top;
    text-align: left;
}
#formatsInfo table {
    border-collapse: collapse;
}
#formatsInfo tr, #formatsInfo th, #formatsInfo td {
    display: block;
    padding: 0;
}
#formatsInfo h3, #formatsInfo th {
    margin: 16px 0 0 0;
    font-size: medium;
    color: var(--primary-color-light);
}
#formatsInfo span, #formatsInfo td {
    color: var(--primary-text-color);
}

#whyUs {
    background-color: var(--primary-background-color);
    padding: 1px 20vw 24px 20vw;
}
#whyUs > div, #faq > div, #howTo {
    text-align: left;
}
@media (max-width: 1200px) {
    #whyUs {
        padding: 1px 10vw 24px 10vw;
    }
}
#whyUs h3 {
    margin-bottom: 4px;
}
.faq-icon {
    fill: var(--primary-color-light);
    margin-top: -4px;
}
.faq-q {
    font-size: x-large;
    font-weight: normal;
    margin-top: 0;
    margin-bottom: 18px;

    color: var(--primary-text-color);
}
.faq-a {
    line-height: 22px;
}
#howTo .chip {
    margin: -6px 2px;
}

#aboutConverter {
    text-align: left;
    line-height: 1.5em;
}

#trust {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
#trust > .card {
    max-width: 320px;
    margin: 6px;
}
.trust-icon {
    width: 80px;
    fill: var(--primary-color-light);
}
.trust-title {
    font-size: x-large;
    font-weight: normal;
    margin: 20px;
    color: var(--primary-text-color);
}
.trust-desc {
    line-height: 22px;
}

#getApp {
    padding: 6px;
}
#getApp img {
    height: 48px;
    padding: 1px;
}

#socialMedia > a.button {
    display: inline-block;
}

.ad-label {
    display: inline-block;
    padding: 2px 4px;
    border-radius: 0 0 2px 2px;
    text-align: center;
    text-decoration: none;
    color: #fff;
    background: var(--primary-color);

    position: relative;
    left: 50%; 
    transform: translateX(-50%);

    animation: fade-in .3s 1s both;
}
.adsbygoogle, #bottomUnit {
    max-width: min(832px, calc(100vw - 32px));
    margin: auto;
    text-align: center;
}
.adsbygoogle {
    margin-top: -10px; /* works for #bottomUnit too */
}
.below-filesListCard {
    max-width: 600px;
    text-align: center;
    background-color: var(--primary-color);
    color: #fff;
    cursor: pointer;

    animation: fade-slide-in .4s var(--incoming-bezier) .3s both;
}
.below-filesListCard > div {
    color: #fff;
}

.side-b-container {
    position: absolute;
    top: calc(8vh + 43px); /* margin-tops of #logo and #formatsCard + #logo height */
    width: calc((100vw - 800px - 8vw) / 2); /* #filesListCard */
}
#leftContainer {
    left: 1vw;
    text-align: right;
}
#rightContainer {
    right: 1vw;
}
@media (max-width: 1189px) {
    .side-b-container {
        display: none;
    }
}

.adsbygoogle, #bottomUnit, .side-b-container, .reward-gam {
    color-scheme: normal; /* fix for white "transparency" on dark theme */
}#filesListCard {
    padding-top: 0;

    animation: fade-slide-in .4s var(--incoming-bezier) both;
    opacity: 0;

    min-height: 50px;/* placeholder height */
}

#filesListCard > .toolbar {
    margin-top: 16px;
    margin-bottom: -16px;

    position: sticky;
    top: 0;
    z-index: 2;

    /* In case there are too many items for the device width: */
    overflow-x: auto;
    scrollbar-width: none;
}
@media (max-width: 600px) {
    /*.responsive-list-actions > .button {
        border-radius: 50%;
        padding: 10px;
        margin: 3px;
    }
    .responsive-list-actions .button-icon {
        margin: 0;
    }
    .responsive-list-actions span {
        display: none;
    }*/

    /* Temporary - until the checkboxes are done: */
    #filesListCard > .toolbar {
        justify-content: safe center;
    }
    #filesListCard .toolbar-title {
        display: none;
    }
}
@keyframes top-counter {
    from { opacity: 0; transform: translateY(-20px) }
    to { opacity: 1; transform: translateY(0) }
}
@keyframes bottom-counter {
    from { opacity: 0; transform: translateY(20px) }
    to { opacity: 1; transform: translateY(0) }
}

.file-item {
    margin: 16px -16px -16px -16px;
    user-select: none;

    /*content-visibility: auto;
    contain-intrinsic-size: auto 68px;*/
}
.file-item-contents {
    display: flex;
    align-items: center;
    padding: 16px 16px 12px 16px;
}
.file-icon {
    width: 24px;
    height: 24px;
    padding-right: 14px;
    flex-shrink: 0;
}
.file-status-container {
    flex-grow: 1;
    overflow: hidden;
    user-select: text;
}
.filename {
    color: var(--primary-text-color);
}
.file-status {
    font-size: 14px;
}
.file-status.error {
    color: var(--error-color);
}
.file-actions {
    height: 24px;
    flex-shrink: 0;
    padding-left: 10px;
    margin-right: -6px;
}
.file-actions > svg {
    width: 24px;
    height: 24px;
    cursor: pointer;
    border-radius: 50%;
    padding: 6px;
    margin: -6px 0;
    transition: background-color .28s var(--standard-bezier);
}
.file-actions > svg:focus,
.file-actions > svg:hover {
    background-color: rgba(0,0,0,.2);
}
.file-actions > .error {
    fill: var(--error-color);
}
.file-actions > .disabled {
    fill: var(--disabled-color);
    background-color: unset !important;
    cursor: default;
}
.file-item > .progress-bar {
    margin: 0;
}

#dropMoreOverlay {
    display: none;

    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    pointer-events: none;
    text-align: center;
    letter-spacing: .3px;
    font-size: 24px;
    color: #008000;

    animation: fade-in .28s var(--incoming-bezier);
}
#dropMoreOverlay > b {
    display: block;
    padding: 20px 0;
    position: sticky;
    top: 35%;
}
#filesListCard > *:not(#dropMoreOverlay) {
    transition: opacity .28s var(--standard-bezier);
}
#filesListCard.dropping-more > *:not(#dropMoreOverlay) {
    opacity: .2;
}
#filesListCard.dropping-more > #dropMoreOverlay {
    display: block;
}#downloads {
    max-width: 800px;
}
#btnDownloadZip,
#btnDownloadDir {
    width: 100%;
    margin-bottom: 8px;
}
#btnDownloadDir {
    margin-bottom: 16px;
}
.btn-sub {
    color: #eee;
    font-size: small;
}
.button:disabled > .btn-sub {
    color: inherit;
}

.download-item {
    display: flex;
    padding: 8px 0;
    align-items: center;

    border-top: 1px solid var(--disabled-color);

    cursor: pointer;

    /*content-visibility: auto;
    contain-intrinsic-size: auto 48px;*/
}
.download-item.no-preview {
    contain-intrinsic-size: auto 36px;
}
.file-preview {
    width: 48px;
    height: 48px;
    object-fit: cover;
    margin-right: 14px;
    border-radius: 4px;
    background-color: var(--disabled-color);
    user-select: none;
    pointer-events: none;
}
.file-name {
    flex: 1;
    color: var(--primary-text-color);
}
.action-btn {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    padding: 6px;
    margin-right: -6px;
    fill: var(--secondary-text-color);
    transition: background-color .28s var(--standard-bezier);
}
.action-btn:focus,
.action-btn:hover {
    background-color: rgba(0,0,0,.2);
}
.action-btn.share-btn {
    margin-right: 6px;
}
.action-btn.disabled {
    fill: var(--disabled-color);
    background-color: unset !important;
    cursor: default;
}#filesDropCard {
    text-align: center;
    margin-top: 6vh;
    
    animation: fade-slide-in .4s var(--incoming-bezier) .1s both;
    opacity: 0;
}
#dropArea {
    display: flex;
    justify-content: center;
    flex-direction: column;
    overflow-x: hidden;
    height: 40vh;
    min-height: 160px;
    max-height: 260px;
    font-weight: bold;
    letter-spacing: .3px;
    margin: -16px;
    cursor: pointer;
    user-select: none;

    position: relative;
    
    transition: none .28s var(--standard-bezier);
    transition-property: color, fill;
}
#dropArea > div {
    margin: 4vh 16px;
    font-size: 24px;
}
#dropArea .smaller {
    font-size: 20px;
    margin-top: 4px;
}
#dropArea .smallest {
    font-size: 10px;
    margin-top: 6px;
    font-weight: normal;
}
#dropArea.highlighted {
    color: #008000;
    fill: #008000;
}
#uploadSVG {
    max-height: 70px;
    margin-top: 4vh;
    
    transition: transform .28s var(--standard-bezier);
}
#filesDropCard:hover #uploadSVG,
#filesDropCard:focus-visible #uploadSVG {
    transform: scale(1.2);
}
#dropArea.highlighted > #uploadSVG {
    transform: scale(1.5);
}
input[type=file] {
    display: none;
}

@media (min-width: 501px) {
    #dropArea .mobile {
        display: none;
    }
}
@media (max-width: 500px) {
    #dropArea .desktop {
        display: none;
    }
}#fsa {
    max-width: 800px;
    color: var(--primary-text-color);
}

#fsaSavingList,
#fsaSavedList {
    margin-top: 8px;
}
#fsaSavingList {
    margin-bottom: 24px;

    height: 156px;
    overflow-y: auto;
}

#fsaSavingList:empty::before {
    content: 'Waiting for more conversions to finish...';
    animation: fade-in .28s var(--incoming-bezier);
}
#fsaSavingList.no-folder:empty::before {
    content: 'First, choose a folder to save to...';
}

.save-item {
    display: flex;
    padding: 12px 0;
    border-top: 1px solid var(--disabled-color);
    animation: fade-slide-in-subtle .28s var(--incoming-bezier);

    /*content-visibility: auto;
    contain-intrinsic-size: auto 19px;*/
}
.save-item:last-child {
    border-bottom: 1px solid var(--disabled-color);
}
.save-name {
    flex: 1;
}
.save-progress {
    color: var(--secondary-text-color);
}

.center-in-list {
    display: grid;
    place-items: center;
    height: 100%;
    animation: fade-in .28s var(--incoming-bezier);
}
.center-in-list > svg {
    height: 48px;
}
.txt-status {
    align-self: start;
    font-size: large;
}#gdriveAndroid {
    max-width: 440px;
    color: var(--primary-text-color);
}
#gdriveAndroid img {
    width: 100%;
    border-radius: 3px;
}
#gdriveAndroid .disclaimer {
    padding-bottom: 28px;
}
#gdriveAndroid .button {
    display: block;
    margin: auto;
}.top-highlight {
    position: fixed;
    top: 8px;
    right: 16px;
    z-index: 3;

    animation: fade-slide-from-right .28s var(--incoming-bezier);
}
@media (max-width: 850px) {
    /* mobile drawer is on */
    .top-highlight {
        display: none;
    }
}
#btnAccountTop {
    width: 36px;
    height: 36px;
    box-shadow: var(--elevation-1);
    cursor: pointer;

    transition: box-shadow .28s var(--standard-bezier);
}
#btnAccountTop:hover, #btnAccountTop:focus {
    box-shadow: var(--elevation-3);
}

#linkInstallWide, #btnUpgradeTop {
    position: fixed;
    top: 6px;
    padding: 8px;
    z-index: 3;

    animation: fade-slide-from-top .28s var(--incoming-bezier);
}
#linkInstallWide {
    left: 8px;
}
#btnUpgradeTop {
    right: 68px;
}
@media (max-width: 850px) {
    #linkInstallWide {
        display: none;
    }
    #btnUpgradeTop {
        display: none;
    }
}
@media (max-width: 1220px) {
    /* don't overlap while convertList/targetFormats is visible */
    .widest-only {
        position: absolute !important;
    }
}

#logoContainer {
    text-align: center;
}
#logo {
    margin-top: 4vh;
    margin-bottom: -4px;
    max-width: 300px;
    width: 90vw;
    fill: var(--primary-text-color);
    
    transition: fill .28s var(--standard-bezier);
}
.description {
    font-weight: normal;
    text-align: center;
    margin-top: 4vh;
    
    transition: opacity .28s var(--standard-bezier);
}
.in-view {
    animation: fade-slide-in-subtle .28s var(--incoming-bezier);
}
#mainDescription {
    margin-left: 8vw;
    margin-right: 8vw;
    font-size: large;
}

#allFormatsContainer {
    margin-top: 0;
}
#allFormatsContainer > .section-heading {
    font-size: x-large;
}

#inputSources {
    margin-top: 0;
}
#inputSources > button {
    animation: fade-slide-in-subtle .28s var(--incoming-bezier);
}
@media (max-width: 1100px), (max-height: 600px) {
    /* Google Drive Picker */
    .picker-dialog {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        bottom: 0 !important;
        right: 0 !important;
    }
    .picker-dialog-content {
        width: 100% !important;
        height: 100% !important;
    }
}

#icSeeInfo {
    width: 18px;
    vertical-align: top;
    fill: var(--secondary-text-color);
    margin-left: -4px;
    cursor: pointer;

    transition: fill .1s var(--standard-bezier);
}
#icSeeInfo:hover,
#icSeeInfo:focus {
    fill: var(--primary-color-light);
}

.formats-type-container {
    display: inline-block;
    vertical-align: top;
    text-align: left;
    margin: 4px;
    width: 250px;
    user-select: none;

    --arrow-default-offset: -20px;
    --arrow-active-offset: 10px;
}
@media (max-width: 620px) {
    .formats-type-container {
        width: 40vw;
    }
}
@media (max-width: 530px) {
    .formats-type-container {
        width: calc(100vw - 48px);
        max-width: 280px;
    }
    .format-type-toolbar {
        position: sticky;
        top: 0;
        z-index: 2;
    }
}
.formats-arrow-reverse {
    --arrow-default-offset: 10px;
    --arrow-active-offset: -20px;
}
.formats-list {
    overflow-y: auto;
    scrollbar-width: thin;
    margin: -16px;
}
@media (min-width: 530px) {
    .formats-list {
        max-height: 900px; /* arbitrary length, based on the longest list (audio) */
        height: min(40vh, 350px);
        min-height: 150px;
        resize: vertical;
    }
    .formats-list::-webkit-resizer {
        background-image: url(../img/resize.svg);
        background-repeat: no-repeat;
        background-position: bottom 1px right 1px;
    }
}
.format-list-item {
    display: block;
    padding: 14px 0;
    padding-left: 16px;
    border-bottom: 1px solid rgba(120,120,120,.3);
    transition: background-color .28s var(--standard-bezier);
}
.format-list-item:hover,
.format-list-item:focus {
    background-color: var(--secondary-background-color);
}
.format-list-item:hover > .format-arrow,
.format-list-item:focus > .format-arrow,
.item-selected > .format-arrow {
    transform: translateX(0);
    opacity: 1;
}
.item-selected {
    font-weight: bold;
}
.format-list-item:active > .format-arrow {
    transform: translateX(var(--arrow-active-offset));
    opacity: .5;
}
.format-arrow {
    width: 24px;
    margin-right: 12px;
    margin-top: -2px;
    float: right;

    opacity: 0;
    transform: translateX(var(--arrow-default-offset));
    transition: none .2s;
    transition-property: opacity, transform;
}
@media (max-width: 530px) {
    .format-arrow {
        transform: translateX(0);
        opacity: 1;
    }
}#history {
    max-width: 800px;

    color: var(--secondary-text-color);
    fill: var(--secondary-text-color);
}

#autoDelContainer,
#unavContainer {
    text-align: center;
}

#convHistoryList {
    margin: -20px -4px 32px -4px;
}#drawerOpener {
    position: fixed;
    bottom: 16px;
    right: 16px;
    z-index: 2;
    
    box-sizing: border-box;
    border: none;
    border-radius: 24px;
    padding: 0 20px;
    height: 50px;
    vertical-align: middle;
    text-align: center;
    color: #fff;
    fill: #fff;
    background-color: var(--primary-color);
    box-shadow: 0 3px 5px -1px rgba(0,0,0,.2), 0 6px 10px 0 rgba(0,0,0,.14), 0 1px 18px 0 rgba(0,0,0,.12);
    font-size: 16px;
    font-weight: 700;
    line-height: 36px;
    overflow: hidden;
    outline: none;
    cursor: pointer;
    transition: none .28s var(--standard-bezier);
    transition-property: box-shadow, transform, opacity; /* transform and opacity: used for hiding */
}
#menuSVG {
    width: 24px;
    height: 24px;
    padding-right: 10px;
    vertical-align: middle;
    margin-top: -3px;
}
#drawerOpener.hidden {
    transform: translateY(100px);
    opacity: 0;
}
@media (min-height: 500px) {
    #drawerOpener {
        bottom: 22px;
    }
}
/* Overlay */
#drawerOpener::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: var(--primary-background-color);
    opacity: 0;
    transition: opacity .28s;
}
#drawerOpener:hover, #drawerOpener:focus {
    box-shadow: 0px 5px 5px -3px rgba(0, 0, 0, .2), 0px 8px 10px 1px rgba(0, 0, 0, .14), 0px 3px 14px 2px rgba(0, 0, 0, .12);
}
#drawerOpener:active {
    box-shadow: 0 16px 24px 2px rgba(0, 0, 0, .2), 0  6px 30px 5px rgba(0, 0, 0, .14), 0  8px 10px -5px rgba(0, 0, 0, .12);
}
#drawerOpener:hover::before,
#drawerOpener:focus::before {
    opacity: .08;
}
#drawerOpener:hover:focus::before {
    opacity: .1;
}
#drawerOpener:active::after {
    opacity: .1;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0s;
}


nav {
    box-shadow: var(--elevation-3);
    user-select: none;

    pointer-events: auto; /* prevent :hover sticking on mobile after closing */
}
nav a {
    padding: 10px;
    color: inherit;

    text-decoration: none;
    text-transform: uppercase;
    border-radius: 3px;
    transition: background-color .2s var(--standard-bezier);
}
nav a:hover,
nav a:focus {
    background-color: rgba(187, 187, 187, .3);
}

.navbar-icon {
    fill: inherit;
    margin-top: -6px;
    margin-bottom: -4px;
}

#btnUpgradeTop, #btnUpgradeMobile {
    background-color: var(--accent-color) !important;
    color: var(--primary-color) !important;
    fill: var(--primary-color) !important;
    font-weight: bold;
}

#linkInstall {
    cursor: pointer;
}
#txtShareTarget {
    color: var(--secondary-text-color);
    text-transform: none;
    padding-top: 6px;
}

@media (max-width: 850px) {
    /* mobile drawer */
    nav a {
        display: block;
        padding: 12px;
        margin: 6px;
    }
    nav {
        z-index: 4;
        position: fixed;
        bottom: 0;
        width: 100vw;
        overflow-y: auto;
        max-height: 100vh;
        overscroll-behavior-y: contain; /* prevent body scrolling behind overlay */
        transform: translateY(var(--drawer-pos, 100%));

        text-align: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;

        background-color: var(--primary-background-color);
        color: var(--primary-text-color);
        fill: var(--primary-text-color);

        /* iOS pill fix */
        padding-bottom: env(safe-area-inset-bottom);
    }
    nav:not(.touching) {
        transition: transform .3s var(--standard-bezier);
    }
    nav::before {
        content: '';
        display: inline-block;
        height: 4px;
        width: 34px;
        border-radius: 2px;
        background: #bbb;
    }
    #linkPricingDesktop {
        display: none;
    }
}

@media (min-width: 850px) {
    /* desktop bottom bar */
    #drawerOpener {
        transform: translateY(100px);
        opacity: 0;
    }
    nav {
        position: fixed;
        bottom: 0;
        width: calc(100% - 28px);
        text-align: center;
        padding: 14px;
        /* iOS pill fix */
        padding-bottom: max(14px, env(safe-area-inset-bottom));

        background: var(--primary-color);
        color: #fff;
        fill: #fff;
    
        animation: fade-slide-in .4s var(--incoming-bezier) both;
    }
    #linkUpgradeMobile {
        display: none;
    }
    #txtShareTarget {
        display: none;
    }
    #linkAccount {
        display: none;
    }
    #linkInstall {
        display: none;
    }
}#rating {
    margin-top: 24px;
    max-width: 160px;
}
#txtRatingTitle {
    font-size: large;
    font-weight: normal;
    margin-top: 0;
}
#txtRatingScore {
    color: var(--primary-text-color);
    font-size: x-large;
    font-weight: bold;
}
#txtRatingVotes {
    font-size: small;
}

.rating-stars {
    --percent: calc((var(--rating) / 5 - 0.01) * 100%); /* -0.01 fixes the offset created by 3px letter-spacing */
    font-size: 25px;
    letter-spacing: 3px;
    text-indent: 3px;
    line-height: 1;
    margin: 6px 0;
    font-family: 'stars';
}
.rating-stars::before {
    content: "\E800\E800\E800\E800\E800";
    background: linear-gradient(90deg, var(--primary-color-light) var(--percent), var(--secondary-background-color) var(--percent));
    -webkit-background-clip: text; /* still needed for chromium */
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
@font-face {
    font-family: 'stars';
    src: url('subset-stars.woff2') format('woff2');
    font-display: swap;
}#share {
    max-width: 500px;
}
#share p {
    color: var(--primary-text-color);
}

#shareBtnsContainer {
    margin-top: 32px;
    text-align: right;
}#formatsCard {
    text-align: center;
    margin-top: 4vh;

    animation: fade-slide-in .4s var(--incoming-bezier) both;
    opacity: 0;
}

#txtFormatsOr {
    margin: 8px 0;
}

#compression, #warnContainer {
    text-align: left;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;

    box-shadow: 0 0 0 1px var(--disabled-color);
    border-radius: 3px;

    animation: fade-in .28s var(--incoming-bezier);
}
#compression > label {
    display: flex;
    align-items: center;
    margin: 8px 14px 8px 0;
}
@media (min-width: 800px) {
    #compression > label {
        display: inline-flex;
    }
}
.radio-name {
    color: var(--primary-text-color);
}
.radio-desc {
    font-size: 14px;
}
input[name='compress-lvl'] {
    margin: 14px;
}

#warnContainer {
    padding: 16px;
    margin-top: 8px;

    text-align: center;
    background-color: var(--error-color);
    color: #fff;
}

#allChipsContainer {
    margin: -14px -10px 0 -10px;
}

#recentContainer {
    white-space: nowrap;
    overflow-x: auto;
    scrollbar-width: none;
}
#recentContainer::-webkit-scrollbar {
    display: none;
}
#recentFormatsIcon {
    width: 24px;
    vertical-align: middle;
}
#recentContainer > .chip {
    animation: fade-slide-from-right .4s var(--incoming-bezier);
}

#categoriesContainer {
    display: flex;
    justify-content: center;
    gap: 6px;
}
@media (max-width: 600px) {
    #categoriesContainer {
        flex-direction: column;
    }
}
.chips-category {
    border-radius: 10px;
    background: linear-gradient(to bottom right, var(--color), transparent);

    animation: fade-in .28s var(--incoming-bezier);
}

body:not(.dark) .chips-category > .chip {
    background-color: var(--primary-background-color);
}
.chips-category > .chip {
    opacity: 1;
}
#allChipsContainer .chip.preferred {
    background-color: var(--disabled-bg-color);
    font-weight: bold;
}
#allChipsContainer .chip.not-matching {
    opacity: .1;
}
@media (max-width: 600px) {
    /* Better UX on mobile instead of fading out */
    #categoriesContainer .chip.not-matching {
        display: none;
    }
}

#srchContainer {
    background-color: var(--primary-background-color);
    padding: 8px;
    margin: -10px 0;
    border-radius: 3px;
}
#srchFormats {
    margin: 0;
    max-width: 176px;
    width: 100%;
}
@media (max-width: 500px) {
    #srchFormats:placeholder-shown:not(:focus) {
        max-width: 0;

        /* Material Design Input-related: */
        border-bottom: 0;
        padding-left: 24px;
    }
}

#btnStart {
    display: block;
    margin: auto;
    margin-top: 12px;
}

#txtTermsDisclaimer {
    padding-top: 12px;
}

#formatsCard > .checkbox-container {
    margin-top: 12px;
}

#donateExplainer {
    margin-bottom: 8px;
}

#rateContainer {
    margin-bottom: 8px;
}
#icStars {
    height: 24px;
    fill: var(--secondary-text-color);
    display: block;
    margin: 0 auto 8px;
}

#autoDeleteContainer {
    margin-bottom: 8px;
    flex-wrap: wrap;
}
#autoDeleteContainer, #autoDeleteFlex {
    display: flex;
    justify-content: center;
    align-items: center;
}
#icSecureDelete {
    width: 24px;
    flex-shrink: 0;
}
#txtAutoDeleteTip {
    margin-left: 8px;
}
#icConvertMore {
    width: 24px;
    fill: var(--primary-color-light);
    vertical-align: middle;
    margin-top: -3px;
    margin-right: 6px;
}
@media (min-width: 700px) {
    #autoDeleteContainer {
        margin-top: -10px;
    }
    #btnDeleteAll {
        /* fix offset caused by button's ripple padding area: */
        margin-right: -14px;
    }
}

#line {
    margin: -20px -16px 4px -16px;
    border-top: 1px solid var(--secondary-text-color);
}
#doneFragment > div:not([style*="none"]) ~ #line {
    /* All content above the line has display:none */
    margin-top: 0;
}#tutAddon {
    position: fixed;
    top: -3px;
    left: 50%;
    box-shadow: var(--elevation-3);
    z-index: 3;
    /* top+bottom card padding and top position: */
    max-height: calc(100vh - 32px - 10px);
    overflow-y: auto;
    scrollbar-width: thin;
    text-align: center;

    transform: translate(-50%, -100%);
    transition: transform .3s var(--standard-bezier);
}
#txtAddonHeading {
    color: var(--primary-text-color);
    font-weight: normal;
    margin: 0 0 16px 0;
}
#imgAddon {
    width: 480px;
    height: 300px;
    margin-top: 8px;
    border-radius: 2px;
    outline: 1px solid var(--disabled-color);
}

#tutAddonActions {
    display: flex;
    gap: 4px;

    margin-bottom: -10px;
}
#linkAddon {
    margin-left: auto;/* to stick to the right */
}#unlockReward {
    max-width: fit-content;
}

#txtUnlockTitle {
    font-weight: normal;
    text-align: center;
}
#txtSize {
    display: inline-block;
}
#unlockOptionsContainer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
}

#rewardAvailability {
    text-align: center;
    margin-top: 16px;
}.sparkle > path {
    animation: 2s sparkle infinite alternate;
}
.sparkle > path:nth-child(2) {
    animation-delay: .9s;
}
.sparkle > path:nth-child(3) {
    animation-delay: 1.8s;
}
@keyframes sparkle {
    from { opacity: 1; }
    to { opacity: .3; }
}

/* <dialog> */
#upgrade, #verifyUpgrade {
    max-width: 440px;
    color: var(--primary-text-color);
}
@media (min-width: 910px) {
    #upgrade {
        max-width: 1000px;
    }
}

/* TODO rework this hacky mess: */
#upgrade .toolbar-in-dialog {
    width: 24px;
    background: none;
    box-shadow: none;
    position: absolute;
    top: 20px;
    right: 20px;
}
#upgrade .toolbar-in-dialog button {
    fill: var(--secondary-text-color);
}
#upgradeLoading {
    top: -20px;
}

#icUpgradeCircled, #icVerifyUpgrade {
    width: 100px;
    display: block;
    margin: auto;
    padding: 10px;
    border-radius: 50%;
    background-color: var(--secondary-background-color);
    fill: var(--primary-color-light);
}
#icUpgradeCircled, #icVerifyUpgrade {
    background-color: #fff;
    filter: drop-shadow(0 3px 6px var(--primary-color));
    transform: translateY(4px);
}
#icUpgradeCircled.pulsing {
    animation: 2.5s glow-shadow infinite alternate cubic-bezier(.6, .2, .2, 1);
}
@keyframes glow-shadow {
    from { filter: drop-shadow(0 3px 6px var(--primary-color)); transform: translateY(4px); }
    to { filter: drop-shadow(0 3px 12px var(--primary-color)); transform: translateY(-4px); }
}
/* Selectors performance possibly problematic: */
body.dark #icUpgradeCircled, body.dark #icVerifyUpgrade {
    background-color: #000;
}
body.dark #icUpgradeCircled > path {
    filter: drop-shadow(0 0 6px var(--primary-color));
}
#txtUpgradeHeading, #txtUpgradeSubheading,
#txtVerifyHeading, #txtVerifySubheading {
    text-align: center;
    margin-bottom: 0;
}
#txtUpgradeSubheading, #txtVerifySubheading {
    font-weight: normal;
    margin-top: 4px;
}
#txtUpgradeHeading, #txtUpgradeSubheading {
    animation: fade-slide-in-subtle .28s both .1s var(--incoming-bezier);
}
#txtUpgradeSubheading {
    animation-delay: .2s;
}
.features-list {
    flex-grow: 1;
    padding-left: 0;
}
.features-list.sublist {
    padding-left: 30px;
}
.features-list > li {
    list-style-type: none;
    padding-bottom: 8px;
}
.features-list.sublist > li {
    padding-bottom: 0;
}
.features-list:not(.sublist) > li:before {
    content: '';
    display: inline-block;
    margin: 0 6px -6px 0;
    width: 24px;
    height: 24px;
    background-image: url('../img/check.svg');
}
.features-list:not(.sublist) > li > b,
#frequencySwitches b {
    color: var(--primary-color-light);
}
.ic-learn-more {
    width: 16px;
    fill: var(--secondary-text-color);
    cursor: pointer;
    position: relative;
    top: 2px;
}
.sublist-anim {
    animation: fade-slide-in-subtle .28s both var(--incoming-bezier);
}

#plans {
    padding-top: 24px;
    display: grid;
}
.plan > * {
    color: var(--primary-text-color);
}
.plan {
    display: flex;
    flex-direction: column;

    box-shadow: none !important;
    transition-property: filter, transform;
    filter: drop-shadow(0 3px 6px var(--primary-color));
}
.plan:hover {
    filter: drop-shadow(0 3px 12px var(--primary-color));
}
.plan.highlighted {
    filter: drop-shadow(0 3px 12px var(--accent-color));
}
.plan-title {
    margin: 0;
    text-align: center;
}
@media (min-width: 910px) {
    #plans {
        grid-auto-flow: column;
        grid-auto-columns: 1fr;
        gap: 16px;
    }
}
@media (max-width: 910px) {
    .plan {
        min-width: fit-content;
        width: 270px;
        margin-left: auto;
        margin-right: auto;
    }
}

#plans.two-mode {
    grid-auto-columns: auto;
    justify-items: center;
	justify-content: center;
}
#plans.two-mode .plan {
    width: 290px;
}

#contactSalesContainer {
    text-align: center;
    margin-bottom: -8px;
}

.upgrade-section-heading {
    text-align: center;
    font-weight: normal;
    font-size: 20px;

    padding-top: 36px;

    margin-bottom: 8px;
}

.testimonial > .rating-stars {
    --rating: 5;
    float: right;
}
.testimonial-name {
    color: var(--primary-text-color);
}
.testimonial-date {
    font-size: small;
}
.testimonial-body {
    margin-top: 12px;
    font-size: 15px;
}
#testimonials {
    display: flex;
    gap: 8px;

    overflow-x: auto;
    margin: -20px; /* box-shadow fix for overflow-x */
    padding: 20px;
    padding-bottom: 4px;
    margin-bottom: 4px;

    scrollbar-width: thin;
}
.testimonial {
    min-width: min(390px, calc(100vw - 92px));
    scroll-snap-align: center;
}
@media (max-width: 910px) {
    #testimonials {
        scroll-snap-type: x mandatory;
    }
}

#customerLogosContainer {
    text-align: center;
    user-select: none;
}
#customerLogosContainer > img {
    aspect-ratio: 5 auto;
    height: 24px;
    margin: 8px 12px;

    vertical-align: middle;

    filter: grayscale(1) brightness(.6) contrast(10) invert(.5);
    opacity: .8;
}
.smaller-customer-logo {
    height: 18px !important;
}

#premiumFAQ {
    max-width: 600px;
    margin: 0 auto 24px auto;
}
#premiumFAQ .faq-q {
    font-size: 18px;
}
#premiumFAQ.subs .q-one-off {
    display: none;
}
#premiumFAQ:not(.subs) .q-sub {
    display: none;
}
#premiumFAQ.aw .q-no-aw {
    display: none;
}

#btnRewardedAdmob {
    display: block;
    margin: 3px auto 4px auto;
}

.pay-options {
    display: flex;
    gap: 6px;
}
.pay-options button.button {
    width: 100%;
    white-space: nowrap;
}
.price, .price-details {
    font-size: smaller;
    color: #eee;
}
.price-old {
    font-size: x-small;
    color: #ccc;
}
.price-old:not(:empty) {
    margin-left: 4px;
}
.deemphasized {
    outline: 1px solid;
}
.deemphasized > * {
    color: unset;
}
.hover-details .price,
.hover-details .price-old {
    animation: fade-in .2s;
}
.hover-details:hover .price,
.hover-details:hover .price-old {
    display: none;
}
.price-details {
    display: none;
}
.hover-details:hover .price-details {
    display: inline-block;
    animation: fade-slide-in-subtle .2s;
}

#switchesFieldset {
    all: unset;
    display: block;
    margin-top: 16px;
    text-align: center;
}
#frequencySwitches, .pay-methods {
    display: inline-block;
    width: fit-content;
    margin: auto;
    box-shadow: 0 0 0 1px var(--disabled-color);
    border-radius: 3px;
}

#frequencySwitches {
    padding: 2px 6px 6px 6px;
}
#switchesFieldset[disabled] .chip {
    opacity: .1;
}

.pay-methods {
    margin-left: 8px;
    vertical-align: top;
    user-select: none;
}
.pay-methods img {
    aspect-ratio: 1.4 auto;
    height: 20px;
    margin: 0 .5px;
    vertical-align: middle;
}
.pay-methods:not(.in-china) img.chinese {
    display: none;
}
.pay-methods .rounded {
    border-radius: 2px;
}
.pay-methods label {
    display: inline-block;
    padding: 6px;
}
.pay-methods label:nth-of-type(2) {
    display: block;
    border-top: 1px solid var(--disabled-color);
}
.pay-methods input {
    margin: 0 4px 0 0;
    vertical-align: middle;
}

@media (max-width: 910px) {
    .pay-methods {
        margin-top: 8px;
        margin-left: 0;
    }
}

.pay-disclaimer, #alreadyBought {
    text-align: center;
}#bubDiscount {
    position: absolute;
    position-anchor: --discounted-btn-anchor;
    bottom: anchor(top);
    justify-self: anchor-center;
    margin-bottom: 0;

    min-width: 180px;

    background: #F9A825;
    box-shadow: var(--elevation-3);
    text-align: center;
    cursor: pointer;

    clip-path: circle(0 at 50% 110%);
    transition: clip-path .5s var(--incoming-bezier);
}
#bubDiscount.rippled-shown {
    clip-path: circle(100% at 50% 110%);
}
#bubDiscount::before {
    content: '';
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid #F9A825;

    position: absolute;
    bottom: -9px; /* -10px glitches on some zoom levels */
    left: calc(50% - 10px);/* center (element is 20px wide) */
}
#bubDiscount.manual-anchor {
    position: fixed;
    transform: translateX(-50%);
}
#bubDiscount > * {
    color: #000;
}
#bubDiscount > h2 {
    font-weight: normal;
    margin: 0 0 12px 0;
}
#bubDiscount > .disclaimer {
    margin-top: 6px;
}

#btnCloseBub {
    all: unset;

    width: 18px;
    height: 18px;
    
    position: absolute;
    right: 2px;
    top: 2px;

    fill: #666;
    border-radius: 50%;
    
    transition: background .28s var(--standard-bezier);
}
#btnCloseBub:hover, #btnCloseBub:focus {
    background: rgba(0, 0, 0, .1);
}#verifyUpgrade {
    height: 500px;
    overflow-y: hidden !important;
}

#confetti {
    position: absolute;
    left: 0;
    top: 64px;
    width: 100%;
    height: 476px;/* based on <dialog> height */
    z-index: -1;
}

#icVerifyUpgrade, #txtVerifyHeading, #txtVerifySubheading {
    transition: none .3s;
    transition-property: transform, opacity;
}

#btnContinue {
    display: block;
    margin: 40px auto 0 auto;

    position: relative;
    z-index: 2;

    animation: fade-in .3s;
}

#multiDevice {
    position: absolute;
    bottom: 12px;
    right: 24px;
    left: 24px;

    text-align: center;
    color: var(--secondary-text-color);
    fill: var(--secondary-text-color);

    animation: fade-slide-in-subtle .3s var(--incoming-bezier);
}

/* For small heights - landscape phones: */
@media (max-height: 480px) {
    #icVerifyUpgrade {
        width: 48px;
    }
}
@media (max-height: 430px) {
    #btnContinue {
        margin-top: 10px;
    }
}
@media (max-height: 380px) {
    #txtVerifyHeading {
        margin-top: 6px;
    }
}