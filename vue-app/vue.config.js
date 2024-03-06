const path = require('path');
const myTheme = path.resolve(__dirname, "./src/assets/less/self.less");

function resolve (dir) {
    return path.resolve(__dirname, dir)
}

module.exports = {    
    publicPath: './',
    lintOnSave: true,
    chainWebpack: config => {
        config.resolve.alias
            .set('@', resolve('src'))
        
        config.plugin('html') .tap(args => {
            args[0].title = "";
            return args
        });
    },
  
}