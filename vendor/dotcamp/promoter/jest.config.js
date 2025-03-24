const config = {
	testEnvironment: 'jsdom',
	testMatch: [ '**/__tests__/js/unit/**/*.test.js' ],
	moduleNameMapper: {
		'^@Containers(.*)$': '<rootDir>/src/containers$1',
		'^@Components(.*)$': '<rootDir>/src/components$1',
		'^@Hoc(.*)$': '<rootDir>/src/hoc$1',
		'^@Utils(.*)$': '<rootDir>/src/utils$1',
	},
};

module.exports = config;
