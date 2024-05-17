import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,mdx}',
    './src/app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic':
          'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))', heroyellow: 'url("/assets/images/Rectangle2.png")',
        'heroyellow2': 'url("/assets/images/Rectangle5.png")',
        'heroEllipse': 'url("/assets/images/Ellipse.png")',
      },
    },
  },
  plugins: [require("daisyui")],
}
export default config
