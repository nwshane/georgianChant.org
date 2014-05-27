// Transliterates a text from the Georgian alphabet into the Latin alphabet

// TODO Check these rules against the rules in Malkhaz's chant volumes
function standardTransliterationRules(character) {
    var latinChar;

    if (character === "ა") {
        latinChar = "a";
    } else if (character === "ბ") {
        latinChar = "b";
    } else if (character === "გ") {
        latinChar = "g";
    } else if (character === "დ") {
        latinChar = "d";
    } else if (character === "ე") {
        latinChar = "e";
    } else if (character === "ვ") {
        latinChar = "v";
    } else if (character === "ზ") {
        latinChar = "z";
    } else if (character === "თ") {
        latinChar = "t";
    } else if (character === "ი") {
        latinChar = "i";
    } else if (character === "კ") {
        latinChar = "k";
    } else if (character === "ლ") {
        latinChar = "l";
    } else if (character === "მ") {
        latinChar = "m";
    } else if (character === "ნ") {
        latinChar = "n";
    } else if (character === "ო") {
        latinChar = "o";
    } else if (character === "პ") {
        latinChar = "p\'";
    } else if (character === "ჟ") {
        latinChar = "zh";
    } else if (character === "რ") {
        latinChar = "r";
    } else if (character === "ს") {
        latinChar = "s";
    } else if (character === "ტ") {
        latinChar = "t\'";
    } else if (character === "უ") {
        latinChar = "u";
    } else if (character === "ფ") {
        latinChar = "p";
    } else if (character === "ქ") {
        latinChar = "q";
    } else if (character === "ღ") {
        latinChar = "gh";
    } else if (character === "ყ") {
        latinChar = "q";
    } else if (character === "შ") {
        latinChar = "sh";
    } else if (character === "ჩ") {
        latinChar = "ch";
    } else if (character === "ც") {
        latinChar = "ts";
    } else if (character === "ძ") {
        latinChar = "dz";
    } else if (character === "წ") {
        latinChar = "ts'";
    } else if (character === "ჭ") {
        latinChar = "ch'";
    } else if (character === "ხ") {
        latinChar = "kh";
    } else if (character === "ჯ") {
        latinChar = "j";
    } else if (character === "ჰ") {
        latinChar = "h";
    } else {
        latinChar = character;
    }

    return latinChar;
}

function firstCharInSentence(georgianText, index) {
    var previousCharacter = georgianText.charAt(index - 1);

    if (previousCharacter === ".") {
        return true;
    } else if (previousCharacter === " ") {
        return firstCharInSentence(georgianText, index - 1);
    } else {
        return false;
    }
}

function transliterateIntoLatin() {
    var georgianText = jQuery("#georgian-text-meta-box-textarea").val();

    var latinText = "";

    for (var index = 0; index < georgianText.length; index++) {
        var character = standardTransliterationRules(georgianText.charAt(index));

        if (index === 0 || firstCharInSentence(georgianText, index)) {

            var firstLetter = character.substring(0,1);
            var remaining = character.substring(1, character.length);

            character = firstLetter.toUpperCase() + remaining;
        }

        latinText += character;
    }

    jQuery("#latin-transliteration-meta-box-textarea").val(latinText);
}

