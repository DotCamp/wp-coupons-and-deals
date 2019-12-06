const purgecss = require('@fullhuman/postcss-purgecss')({
  content: ['./assets/js/webpack-src/**/*.*'],
  defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
});

module.exports = {
  plugins: [require('tailwindcss'), require('autoprefixer'), ...[purgecss]],
};
