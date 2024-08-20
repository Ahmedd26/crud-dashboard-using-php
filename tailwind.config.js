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
        gray: require("tailwindcss/colors").zinc,
      },
      backgroundImage: {
        "profile-placeholder":
          "url('https://www.gravatar.com/avatar/?d=mp&s=150')",
      },
    },
  },
  plugins: [require("flowbite/plugin")],
};
