// Transliterates a text from the Georgian alphabet into the Latin alphabet

// To run program in terminal from containing directory,
// execute the following command: node georgian-latin-transliterator.js [insert Georgian text]

// TODO Check these rules against the rules in Malkhaz's chant volumes
function standardTransliterationRules(char) {
    var latinChar;
    
    if (char === "ა") {
        latinChar = "a";
    } else if (char === "ბ") {
        latinChar = "b";
    } else if (char === "გ") {
        latinChar = "g";
    } else if (char === "დ") {
        latinChar = "d";
    } else if (char === "ე") {
        latinChar = "e";
    } else if (char === "ვ") {
        latinChar = "v";
    } else if (char === "ზ") {
        latinChar = "z";
    } else if (char === "თ") {
        latinChar = "t";
    } else if (char === "ი") {
        latinChar = "i";
    } else if (char === "კ") {
        latinChar = "k\'";
    } else if (char === "ლ") {
        latinChar = "l";
    } else if (char === "მ") {
        latinChar = "m";
    } else if (char === "ნ") {
        latinChar = "n";
    } else if (char === "ო") {
        latinChar = "o";
    } else if (char === "პ") {
        latinChar = "p\'";
    } else if (char === "ჟ") {
        latinChar = "jh";
    } else if (char === "რ") {
        latinChar = "r";
    } else if (char === "ს") {
        latinChar = "s";
    } else if (char === "ტ") {
        latinChar = "t\'";
    } else if (char === "უ") {
        latinChar = "u";
    } else if (char === "ფ") {
        latinChar = "p";
    } else if (char === "ქ") {
        latinChar = "k";
    } else if (char === "ღ") {
        latinChar = "gh";
    } else if (char === "ყ") {
        latinChar = "q";
    } else if (char === "შ") {
        latinChar = "sh";
    } else if (char === "ჩ") {
        latinChar = "ch";
    } else if (char === "ც") {
        latinChar = "ts";
    } else if (char === "ძ") {
        latinChar = "dz";
    } else if (char === "წ") {
        latinChar = "ts'";
    } else if (char === "ჭ") {
        latinChar = "ch'";
    } else if (char === "ხ") {
        latinChar = "kh";
    } else if (char === "ჯ") {
        latinChar = "j";
    } else if (char === "ჰ") {
        latinChar = "h";
    } else {
        latinChar = char;
    }

    return latinChar;
}

function firstCharInSentence(georgianText, index) {
    var previousChar = georgianText.charAt(index - 1);

    if (previousChar === ".") {
        return true;
    } else if (previousChar === " ") {
        return firstCharInSentence(georgianText, index - 1);
    } else {
        return false;
    }
}

function transliterateIntoLatin(georgianText) {

    var latinText = "";

    for (var index = 0; index < georgianText.length; index++) {
        var char = standardTransliterationRules(georgianText.charAt(index));

        if (index === 0 || firstCharInSentence(georgianText, index)) {

            var firstLetter = char.substring(0,1);
            var remaining = char.substring(1, char.length);

            char = firstLetter.toUpperCase() + remaining;
        }

        latinText += char;
    }

    return latinText;
}

// Outputs transliterated text when program is run with terminal node.js with georgian text parameters
process.argv.forEach(function(val, index, array) {
    if (index > 1) {
        console.log("\n" + val + ": " + transliterateIntoLatin(val) + "\n");
    }
});




