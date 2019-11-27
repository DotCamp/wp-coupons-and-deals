/**
 * put default values to field data based on pairs of type and value fields
 * @param data object raw data object
 * @param pairs object key-value pairs of data type and default value property names
 * @returns object an object of applied defaults
 */
function putSelectionDefaults(data, pairs) {
  const tempObj = {};
  data.map(d => {
    Object.keys(pairs).map(k => {
      if (d.type === k) {
        const valueField = pairs[k];
        if (d[valueField].push) {
          [tempObj[d.id]] = d[valueField];
        } else {
          tempObj[d.id] = d[valueField];
        }
      }
    });
  });
  return tempObj;
}

/**
 * put depend fields to original data sent from the server
 * some of the fields are only visible to certain field values like templates etc.
 * with this function we will be injecting depend fields to the original data so
 * our form can parse this field to decide whether to show that field or not depending
 * on the values it depends on
 * @param data array data array
 * @param pairs array key-value pairs for depend property
 */
function putDepends(data, pairs) {
  return data.map(d => {
    Object.keys(pairs).map(p => {
      if (Object.prototype.hasOwnProperty.call(pairs, p)) {
        if (d.id === p) {
          // eslint-disable-next-line no-param-reassign
          d.depend = pairs[p];
        }
      }
    });
  });
}

export default { putSelectionDefaults, putDepends };
