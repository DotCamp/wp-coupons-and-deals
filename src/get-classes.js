//@ts-ignore
import { isUndefined, trim, isEmpty } from "lodash";

export function getStyleClass(attributes) {
  const { padding, margin } = attributes;
  const isValueEmpty = (value) => {
    return (
      isUndefined(value) ||
      value === false ||
      trim(value) === "" ||
      trim(value) === "undefined undefined undefined" ||
      isEmpty(value)
    );
  };

  return {
    "has-padding": !isValueEmpty(padding),
    "has-margin": !isValueEmpty(margin),
  };
}
