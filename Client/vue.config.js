const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,

  pages: {
    index: {
      // entry for the page
      entry: 'src//main.js',
      // the source template
      template: 'public/index.html',
      // output as dist/index.html
      filename: 'index.html',
      // when using title option,
      // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
      title: 'Main Page',
      // chunks to include on this page, by default includes
      // extracted common chunks and vendor chunks.
      chunks: ['chunk-vendors', 'chunk-common', 'index']
    },
    posts: {
      // entry for the page
      entry: 'src/pages/Posts/main.js',
      // the source template
      template: 'public/index.html',
      // output as dist/index.html
      filename: 'posts.html',
      // when using title option,
      // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
      title: 'Posts Page',
      // chunks to include on this page, by default includes
      // extracted common chunks and vendor chunks.
      chunks: ['chunk-vendors', 'chunk-common', 'posts']
    },
    dashboard: {
      // entry for the page
      entry: 'src/pages/Dashboard/main.js',
      // the source template
      template: 'public/index.html',
      // output as dist/index.html
      filename: 'dashboard.html',
      // when using title option,
      // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
      title: 'Dashboard',
      // chunks to include on this page, by default includes
      // extracted common chunks and vendor chunks.
      chunks: ['chunk-vendors', 'chunk-common', 'dashboard']
    }
  },
  
})
