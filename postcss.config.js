const purgecss = require('@fullhuman/postcss-purgecss')({
  content: ['./assets/js/webpack-src/**/*.*'],
});

module.exports = {
  plugins: [require('tailwindcss'), require('autoprefixer'), ...[purgecss]],
};
