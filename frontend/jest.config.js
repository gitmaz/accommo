// jest.config.js
module.exports = {
    preset: '@vue/cli-plugin-unit-jest/presets/default',
    testEnvironment: 'jsdom',
    transform: {
        '^.+\\.vue$': 'vue-jest',
        '^.+\\.js$': 'babel-jest'
    },
};
