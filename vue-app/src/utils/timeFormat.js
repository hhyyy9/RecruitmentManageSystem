/**
  * 获取距离指定时间还有多少天
  * @param {String | Number | Date} dateTime 日期时间
  * @example
  * ```javascript
  *     getDistanceSpecifiedTime('2019/02/02 02:02:00');
  *     getDistanceSpecifiedTime(1549036800000);
  *     getDistanceSpecifiedTime(new Date("2019/2/2 00:00:00"));
  * ```
  */
 export function getDistanceSpecifiedTime(dateTime) {
  // 指定日期和时间
  var EndTime = new Date(dateTime);
  // 当前系统时间
  var NowTime = new Date();
  var t = EndTime.getTime() - NowTime.getTime();
  var d = Math.floor(t / 1000 / 60 / 60 / 24)>0?Math.floor(t / 1000 / 60 / 60 / 24):0;
 
  var h = Math.floor(t / 1000 / 60 / 60 % 24)>0?Math.floor(t / 1000 / 60 / 60 % 24):0;
  var m = Math.floor(t / 1000 / 60 % 60)>0?Math.floor(t / 1000 / 60 % 60):0;
  var s = Math.floor(t / 1000 % 60)>0?Math.floor(t / 1000 % 60):0;
  var html = d + "天" + h + "时" + m + "分";
  return html
}

/**
 * 日期字符串转成时间戳
 * @param dateStr 例如var date = '2015-03-05 17:59:00.0'
 * @param {string} cFormat
 * @returns {string}
 */
export function dateStrChangeTimeTamp(dateStr) {
  dateStr = dateStr.substring(0, 19);
  dateStr = dateStr.replace(/-/g, "/");
  return new Date(dateStr).getTime();
}

/**
 * 根据格式转换时间戳
 * @param {(Object|string|number)} time 当前时间
 * @param {string} cFormat 时间格式如：{y}-{m}-{d} {h}:{i}:{s}
 * @returns {string}
 */
export function parseTime(time, cFormat) {
  if (arguments.length === 0) {
    return null;
  }
  const format = cFormat || "{y}-{m}-{d} {h}:{i}:{s}";
  let date;
  if (typeof time === "object") {
    date = time;
  } else {
    if (typeof time === "string" && /^[0-9]+$/.test(time)) {
      time = parseInt(time);
    }
    if (typeof time === "number" && time.toString().length === 10) {
      time = time * 1000;
    }
    date = new Date(time);
  }
  const formatObj = {
    y: date.getFullYear(),
    m: date.getMonth() + 1,
    d: date.getDate(),
    h: date.getHours(),
    i: date.getMinutes(),
    s: date.getSeconds(),
    a: date.getDay(),
  };
  const time_str = format.replace(/{(y|m|d|h|i|s|a)+}/g, (result, key) => {
    let value = formatObj[key];
    // Note: getDay() returns 0 on Sunday
    if (key === "a") {
      return ["日", "一", "二", "三", "四", "五", "六"][value];
    }
    if (result.length > 0 && value < 10) {
      value = "0" + value;
    }
    return value || 0;
  });
  return time_str;
}


/**返回刚刚、几分钟前、几小时前、一天前
 * @param {number} time 时间date
 * @param {string} option  时间格式如{y}-{m}-{d} {h}:{i}:{s}
 * @returns {string}
 */
export function formatTime(time, option) {
  if (("" + time).length === 10) {
    time = parseInt(time) * 1000;
  } else {
    time = +time;
  }
  const d = new Date(time);
  const now = Date.now();

  const diff = (now - d) / 1000;

  if (diff < 30) {
    return "刚刚";
  } else if (diff < 3600) {
    // less 1 hour
    return Math.ceil(diff / 60) + "分钟前";
  } else if (diff < 3600 * 24) {
    return Math.ceil(diff / 3600) + "小时前";
  } else if (diff < 3600 * 24 * 2) {
    return "1天前";
  }
  if (option) {
    return parseTime(time, option);
  } else {
    return (
      d.getMonth() +
      1 +
      "月" +
      d.getDate() +
      "日" +
      d.getHours() +
      "时" +
      d.getMinutes() +
      "分"
    );
  }
}


/**返回的是距离当前日期的day后的时间
//最近一周 getDay(-7)    返回的是距离当前日期的一周后的时间
//一月 getDay(-30)
//一年 getDay(-365)
 * @param {number} day 距离当前的日期的天数
 * @returns {string}
 */
export function getTimeByDay(day) {
  var today = new Date();
  var targetday_milliseconds = today.getTime() + 1000 * 60 * 60 * 24 * day;
  today.setTime(targetday_milliseconds); //注意，这行是关键代码
  var tYear = today.getFullYear();
  var tMonth = today.getMonth();
  var tDate = today.getDate();
  tMonth = doHandleMonth(tMonth + 1);
  tDate = doHandleMonth(tDate);
  return tYear + "-" + tMonth + "-" + tDate;
}
function doHandleMonth(month) {
  var m = month;
  if (month.toString().length == 1) {
    m = "0" + month;
  }
  return m;
}

/**ElementUI的el-date-picker使用使用
 * 实例：
 *   <el-date-picker
          v-model="timePeriod"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd"
          :picker-options="pickerOptions"
        ></el-date-picker>
 */
export const pickerOptions = {
  shortcuts: [
    {
      text: "最近一周",
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
        picker.$emit("pick", [start, end]);
      },
    },
    {
      text: "最近一个月",
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
        picker.$emit("pick", [start, end]);
      },
    },
    {
      text: "最近三个月",
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
        picker.$emit("pick", [start, end]);
      },
    },
  ],
  disabledDate(time) {
    return (
      time.getTime() >=
      new Date(new Date().toLocaleDateString()).getTime() +
        24 * 60 * 60 * 1000
    );
  },
  
}



