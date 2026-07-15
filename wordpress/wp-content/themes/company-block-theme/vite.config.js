import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
  build: {
    emptyOutDir: true,
    outDir: 'assets/dist',
    rollupOptions: {
      input: resolve(__dirname, 'assets/src/theme.css'),
      output: {
        assetFileNames: 'theme.[ext]',
      },
    },
  },
});