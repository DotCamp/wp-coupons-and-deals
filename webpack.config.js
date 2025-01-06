const defaultConfig = require("@wordpress/scripts/config/webpack.config");
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");
// const IgnoreEmitPlugin = require("ignore-emit-webpack-plugin");
// const { CleanWebpackPlugin } = require("clean-webpack-plugin");
// const { DefinePlugin } = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");
// eslint-disable-next-line import/no-extraneous-dependencies
const path = require("path");
const buildPaths = require("./webpackPaths");

const mode = process.env.NODE_ENV || "development";

const config = {
  ...defaultConfig,
  mode,
  target: "web",
  entry: {
    formShortcode: path.resolve(__dirname, buildPaths.input.formShortcode),
    blocks: path.resolve(process.cwd(), "src", "index.js"),
  },
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, buildPaths.output),
  },
  module: {
    rules: [
      {
        test: /.+\.(vue)$/,
        loader: "vue-loader",
      },
      {
        test: /.+\.(js)$/,
        loader: "babel-loader",
      },
      {
        test: /.+\.(css)$/,
        loader: [
          "vue-style-loader",
          { loader: "css-loader", options: { importLoaders: 1 } },
          "postcss-loader",
        ],
      },
      {
        test: /.+\.(svg|png)$/,
        loader: "url-loader",
      },
    ],
  },
  plugins: [new VueLoaderPlugin()],
  resolve: {
    modules: [path.dirname(buildPaths.input.formShortcode), "node_modules"],
    alias: {
      vue$: "vue/dist/vue.esm.js",
    },
    extensions: [".js", ".vue", ".css"],
  },
  devtool: mode === "development" ? "eval" : "none",
};

module.exports = config;
