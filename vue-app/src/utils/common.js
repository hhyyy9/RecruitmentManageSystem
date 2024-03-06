/* 手机号*/
export function isPhone(s){
    var validateReg = /^((\+?86)|(\(\+86\)))?1\d{10}$/;
    return validateReg.test(s);
}

//脱敏
// Desensitization('18353246789097654',4,-4)
// console.log("1835*********765")
export function desensitization(str,beginLen,endLen) {
    var len = str.length;
    var firstStr = str.substr(0,beginLen);
    var lastStr = str.substr(endLen);
    var middleStr = str.substring(beginLen, len-Math.abs(endLen)).replace(/[\s\S]/ig, '*');
    var tempStr = firstStr + middleStr + lastStr;
    return tempStr;
}


