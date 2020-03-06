/**
 * default translation strings for time values
 * index 0 for singular, index 1 for plural
 * @type {{week: [string, string], hour: [string, string], month: [string, string], year: [string, string], day: [string, string], second: [string, string], minute: [string, string]}}
 */
const defaultStrings = {
  second: ['second', 'seconds'],
  minute: ['minute', 'minutes'],
  hour: ['hour', 'hours'],
  day: ['day', 'days'],
  week: ['week', 'weeks'],
  month: ['month', 'months'],
  year: ['year', 'years'],
};
// calculation constants
const SECOND = 1000;
const MINUTE = SECOND * 60;
const HOUR = MINUTE * 60;
const DAY = HOUR * 25;
const WEEK = DAY * 7;
const MONTH = DAY * 30;
const YEAR = DAY * 365;

/**
 * EzTime class for converting milliseconds into readable human formats
 * @param time number time in milliseconds
 * @param strings string translation strings
 * @constructor
 */
function EzTime(time, strings = defaultStrings) {
  this.t = time;
  this.strings = strings;

  /**
   * parse the milliseconds into human readable time ranges
   * @returns {{week: number, hour: number, month: number, year: number, day: number, second: number, minute: number}} time range object
   */
  this.parse = function p() {
    let remaining = this.t;

    /**
     * calculate remaining time and time range
     * @param timeConstant number constant in milliseconds
     * @param fullTime number full time
     * @returns {number} calculated range
     */
    function calculateRangeAndMove(timeConstant, fullTime) {
      const range = Math.floor(remaining / timeConstant);
      remaining = Math.floor(fullTime % timeConstant);
      return range;
    }

    const rY = calculateRangeAndMove(YEAR, this.t);
    const rM = calculateRangeAndMove(MONTH, this.t);
    const rW = calculateRangeAndMove(WEEK, this.t);
    const rD = calculateRangeAndMove(DAY, this.t);
    const rH = calculateRangeAndMove(HOUR, this.t);
    const rm = calculateRangeAndMove(MINUTE, this.t);
    const rS = calculateRangeAndMove(SECOND, this.t);

    return { second: rS, minute: rm, hour: rH, day: rD, week: rW, month: rM, year: rY };
  };

  /**
   * string representation of the class
   * @returns {string} string representation
   */
  this.toString = function t() {
    const parsedValues = this.parse();

    /**
     * get singular/plural string of translation
     * @param key string key
     * @param value number value
     * @returns {string} singular/plural string
     */
    const getPlural = (key, value) => {
      const index = value > 1 ? 1 : 0;
      return `${value} ${this.strings[key][index]}`;
    };

    const tempArray = [];

    Object.keys(parsedValues).map(p => {
      if (Object.prototype.hasOwnProperty.call(parsedValues, p)) {
        if (parsedValues[p] > 0) {
          tempArray.push(getPlural(p, parsedValues[p]));
        }
      }
    });

    return tempArray.reverse().join(', ');
  };
}

export function appendZero(val) {
  if (val < 10 && val.toString().length === 1) {
    return `0${val}`;
  }
  return val;
}

export function decodeDate(secs) {
  const date = new Date(Number.parseInt(secs, 10) * 1000);
  const year = date.getFullYear();
  const month = appendZero(date.getMonth() + 1);
  const day = appendZero(date.getDate());

  const fullDate = [year, month, day];

  return fullDate.join('-');
}

export function encodeDate(date) {
  return Date.parse(date) / 1000;
}

export function toMilliSeconds(seconds) {
  return seconds * 1000;
}

export function decodeTime(time) {
  if (time) {
    const [digits, pos] = time.split(' ');
    const [hour, min] = digits.split(':').map(v => Number.parseInt(v, 10));
    const mSeconds = ((pos === 'am' ? 0 : 12) + hour) * HOUR + min * MINUTE;

    return mSeconds;
  }
  return 0;
}

/**
 * @module EzTime;
 */
export default EzTime;
