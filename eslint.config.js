// eslint.config.js
import eslint from "@eslint/js";
import tseslint from "@typescript-eslint/eslint-plugin";
import tsparser from "@typescript-eslint/parser";
import reactplugin from "eslint-plugin-react";
import reacthooks from "eslint-plugin-react-hooks";
import prettier from "eslint-plugin-prettier";
import globals from "globals";

export default [
  eslint.configs.recommended,
  {
    files: ["**/*.{ts,tsx}"],
    ignores: ["node_modules/**", "dist/**", "build/**"],
    languageOptions: {
      globals: {
        ...globals.browser,
        route: "readonly",
      },
      parser: tsparser,
      parserOptions: {
        ecmaVersion: "latest",
        sourceType: "module",
        ecmaFeatures: {
          jsx: true,
        },
      },
    },
    plugins: {
      "@typescript-eslint": tseslint,
      react: reactplugin,
      "react-hooks": reacthooks,
      prettier: prettier,
    },
    rules: {
      "prettier/prettier": "error",
      "react/react-in-jsx-scope": "off",
      "react/prop-types": "off",
      "@typescript-eslint/no-unused-vars": "error",
    },
    settings: {
      react: {
        version: "detect",
      },
    },
  },
];
