module.exports = {
    content: [
        "./views/**/*.php",
        "./index.php",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("flowbite/plugin")],
};
