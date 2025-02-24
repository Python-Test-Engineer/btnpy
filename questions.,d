
Here are some questions - they may have been answered during the talk but at least one should not have been and I will ensure one is left to carry over to the end so we have a starting point.

1. How do we ensure that the output of one function is of the right structure to be the input of the next function?

This is the issue of structured output. Most frameworks use Pydantic to validate and coerce data. In fact, Pydantic has its own AI library Pydantic.AI

2. How do we avoid innconsistencies/hallucinations? Will temperature=0 do this?

This is the main limitation currently - halluciantions. Mathematatically, temperature=0 would give a zero division so it is actually 0.00001 etc. GPUs have rounding errors and LLMs are all probability based with an element of using random as starting points. 

3. How do we test our Agents/LLM responses?

There are some new testing libraries like RAGAS that provide a framework for this. We can create Ground Truths based on a domain expert or we can get an LLM to create a test dataset.

4. Can one mix and match frameworks/libraries or customise them?

Yes and no!