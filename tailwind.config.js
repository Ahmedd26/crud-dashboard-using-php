const { blue } = require("tailwindcss/colors");

module.exports = {
  darkMode: "class",

  content: [
    "./views/**/*.php",
    "./index.php",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // gray: require("tailwindcss/colors").zinc,
        gray: require("tailwindcss/colors").stone,
        blue: require("tailwindcss/colors").amber,
      },
      backgroundImage: {
        "profile-placeholder":
          "url('https://www.gravatar.com/avatar/?d=mp&s=150')",
      },
    },
  },
  plugins: [require("flowbite/plugin")],
};
