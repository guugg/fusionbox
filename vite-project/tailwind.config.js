import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  mode: 'jit',
  content: [
    './index.html',
    './src/**/*.{js,ts}',
    '../*.php',
    '../App/**/**/*.php',
    '../resources/views/**/*.blade.php'
  ],
  theme: {
    container: {
      center: true,
      padding: '2rem',
      screens: {
        '2xl': '1400px'
      }
    },
    extend: {
      // 禁用默认颜色类
      // colors: false,
      // 定义自己的颜色系统
      extend: {
        colors: {
          text: 'hsl(var(--text))',
          background: 'hsl(var(--background))',
          primary: 'hsl(var(--primary))',
          secondary: 'hsl(var(--secondary))',
          accent: 'hsl(var(--accent))'
        }
      },

      borderRadius: {
        xl: 'calc(var(--radius) + 4px)', // 用CSS变量定义圆角
        lg: 'var(--radius)',
        md: 'calc(var(--radius) - 2px)',
        sm: 'calc(var(--radius) - 4px)'
      },
      fontSize: {
        sm: '0.800rem',
        base: '1rem',
        xl: '1.250rem',
        '2xl': '1.563rem',
        '3xl': '1.954rem',
        '4xl': '2.442rem',
        '5xl': '3.053rem'
      },
      // fontFamily: {
      //   sans: ["var(--font-geist-sans)"], // 字体动态设置
      // },
      fontFamily: {
        heading: 'LXGW WenKai Mono TC',
        body: 'LXGW WenKai Mono TC'
      },
      fontWeight: {
        normal: '400',
        bold: '700'
      }
    }
  },
  // variants: {
  //   extend: {
  //     textColor: ['hover', 'focus', 'active'],
  //     borderColor: ['hover', 'focus', 'active']
  //   }
  // },
  plugins: [typography]
}
