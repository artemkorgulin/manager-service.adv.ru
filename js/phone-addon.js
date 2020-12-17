/*
Input Mask plugin extensions
http://github.com/RobinHerbots/jquery.inputmask
Copyright (c) 2010 -  Robin Herbots
Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
Version: 0.0.0-dev

Дополнительные маски телефонов
*/
(function (factory) {
	if (typeof define === "function" && define.amd) {
		define(["inputmask"], factory);
	} else if (typeof exports === "object") {
		module.exports = factory(require("./inputmask"));
	} else {
		factory(window.Inputmask);
	}
}
(function (Inputmask) {
    var defaultCodes = window.Inputmask.prototype.defaults.aliases.phone.phoneCodes;
    var extendedCodes = defaultCodes.concat([
        { "mask": "+8801###-######", "cc": "BD", "cd": "Bangladesh", "desc_en": "", "name_ru": "Бангладеш", "desc_ru": "" },
        { "mask": "+8610 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8611 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8620 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8621 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8622 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8623 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8624 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8625 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8627 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+8628 ###-##-###", "cc": "CN", "cd": "China (PRC)", "desc_en": "", "name_ru": "Китайская Н.Р.", "desc_ru": "" },
        { "mask": "+821 ##-###-##-##", "cc": "KR", "cd": "Korea (South)", "desc_en": "", "name_ru": "Респ. Корея", "desc_ru": "" },
        { "mask": "+234 ###-###-##-##", "cc": "NG", "cd": "Nigeria", "desc_en": "", "name_ru": "Нигерия", "desc_ru": "" },
        { "mask": "+387-##-##-##-##", "cc": "BA", "cd": "Bosnia and Herzegovina", "desc_en": "", "name_ru": "Босния и Герцеговина", "desc_ru": "" },
        { "mask": "+230-##-##-##-##", "cc": "MU", "cd": "Mauritius", "desc_en": "", "name_ru": "Маврикий", "desc_ru": "" },
        { "mask": "+263-#-###-###-##", "cc": "ZW", "cd": "Zimbabwe", "desc_en": "", "name_ru": "Зимбабве", "desc_ru": "" },
        { "mask": "+500-###-##-##", "cc": "FK", "cd": "Falkland Islands", "desc_en": "", "name_ru": "Фолклендские острова", "desc_ru": "" },
        { "mask": "+290-##-##", "cc": "SH", "cd": "Saint Helena", "desc_en": "", "name_ru": "Остров Святой Елены", "desc_ru": "" },
        { "mask": "+290-###-##", "cc": "SH", "cd": "Tristan da Cunha", "desc_en": "", "name_ru": "Тристан-да-Кунья", "desc_ru": "" },
        { "mask": "+690-##-##", "cc": "TK", "cd": "Tokelau", "desc_en": "", "name_ru": "Токелау", "desc_ru": "" },
        { "mask": "+676-###-##", "cc": "TO", "cd": "Tonga", "desc_en": "", "name_ru": "Тонга", "desc_ru": "" },
        { "mask": "+977-###-###-##-##", "cc": "NP", "cd": "Nepal", "desc_en": "", "name_ru": "Непал", "desc_ru": "" }
    ]);


    Inputmask.extendAliases({
        "phone": {
            alias: "abstractphone",
            phoneCodes: extendedCodes
        }
    });

    return Inputmask;
}));
