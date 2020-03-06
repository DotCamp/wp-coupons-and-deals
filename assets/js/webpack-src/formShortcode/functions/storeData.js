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

export default { putSelectionDefaults };
