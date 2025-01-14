const defaultConfig = require("@wordpress/scripts/config/webpack.config");

const path = require("path");

const camelCaseDash = (string) =>
  string.replace(/-([a-z])/g, (_match, letter) => letter.toUpperCase());

const externals = [
  "api-fetch",
  "block-editor",
  "blocks",
  "components",
  "compose",
  "data",
  "date",
  "htmlEntities",
  "hooks",
  "edit-post",
  "element",
  "editor",
  "i18n",
  "plugins",
  "viewport",
  "ajax",
  "codeEditor",
  "rich-text",
  "primitives",
];

const globals = externals.reduce(
  (external, name) => ({
    ...external,
    [`@wordpress/${name}`]: `wp.${camelCaseDash(name)}`,
  }),
  {}
);

const config = {
  ...defaultConfig,
  entry: {
    front: "./src/front.js",
    index: "./src/index.js",
  },
  output: {
    clean: false,
    path: path.join(__dirname, "./build"),
  },
  plugins: [...defaultConfig.plugins],
  externals: {
    wp: "wp",
    lodash: "lodash",
    react: "React",
    "react-dom": "ReactDOM",
    ...globals,
  },
};

module.exports = config;
