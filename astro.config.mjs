// @ts-check
import { defineConfig } from 'astro/config';
import tailwind from '@astrojs/tailwind';

export default defineConfig({
  site: 'https://santa-cruz.netlify.app',
  trailingSlash: 'never',
  build: { format: 'file' },
  integrations: [
    tailwind({ applyBaseStyles: false }),
  ],
});
