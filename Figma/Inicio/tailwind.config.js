/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        background: "var(--background)",
        border: "var(--border)",
        "colors-labels-vibrant-controls-secondary":
          "var(--colors-labels-vibrant-controls-secondary)",
        dark: "var(--dark)",
        primary: "var(--primary)",
        secondary: "var(--secondary)",
        "secondary-30": "var(--secondary-30)",
        text: "var(--text)",
        white: "var(--white)",
      },
      fontFamily: {
        "body-normal": "var(--body-normal-font-family)",
        "heading-6": "var(--heading-6-font-family)",
        "heading-title": "var(--heading-title-font-family)",
        "link-normal": "var(--link-normal-font-family)",
        "title-hero": "var(--title-hero-font-family)",
      },
    },
  },
  plugins: [],
};
