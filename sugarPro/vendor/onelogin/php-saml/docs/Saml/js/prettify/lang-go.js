PR.registerLangHandler(PR.createSimpleLexer([["pln",/^[\t\n\r \xa0]+/,null,"\t\n\r �\xa0"],["pln",/^(?:"(?:[^"\\]|\\[\S\s])*(?:"|$)|'(?:[^'\\]|\\[\S\s])+(?:'|$)|`[^`]*(?:`|$))/,null,"\"'"]],[["com",/^(?:\/\/[^\n\r]*|\/\*[\S\s]*?\*\/)/],["pln",/^(?:[^"'/`]|\/(?![*/]))+/]]),["go"]);PR.registerLangHandler(PR.createSimpleLexer([["pln",/^[\t\n\r \xa0]+/,null,"\t\n\r �\xa0"],["pln",/^(?:"(?:[^"\\]|\\[\S\s])*(?:"|$)|'(?:[^'\\]|\\[\S\s])+(?:'|$)|`[^`]*(?:`|$))/,null,"\"'"]],[["com",/^(?:\/\/[^\n\r]*|\/\*[\S\s]*?\*\/)/],["pln",/^(?:[^"'/`]|\/(?![*/]))+/]]),["go"]);
