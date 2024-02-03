/** @type {import('prettier').Options} */
const config = {
   printWidth: 130,
   tabWidth: 3,
   singleQuote: true,
   bracketSameLine: true,
   singleAttributePerLine: false,
   phpVersion: '8.2',
   braceStyle: '1tbs',
   plugins: ['@prettier/plugin-php'],
};

module.exports = config;
