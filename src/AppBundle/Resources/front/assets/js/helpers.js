"use strict";

import Handlebars from "handlebars/handlebars.runtime";

Handlebars.registerHelper("dump", (context) => {
    console.log(context);
});

Handlebars.registerHelper("wrapNotes", (text, options) => {
    text = Handlebars.Utils.escapeExpression(text);
    text = text.replace(/\[{2}\s?(\w+)\s?\]{2}/g, "<span class='note'>$1</span>");

    return new Handlebars.SafeString(text);
});

export default "helpers";