const purgecss = require('@fullhuman/postcss-purgecss')({
  content: ['./assets/js/webpack-src/**/*.*'],
  defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
});

const currentEnv = process.env.NODE_ENV || 'development';

module.exports = {
  plugins: [require('tailwindcss'), require('autoprefixer'), ...(currentEnv === 'development' ? [] : [purgecss])],
};
