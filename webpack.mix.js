const mix = require('laravel-mix')

const autoload = {
   jquery: [ '$', 'jQuery', 'jquery']
}
mix.autoload(autoload)

mix.setPublicPath('public')

mix.sass('./resources/sass/app.scss', 'public/css')
   .version()

// Copy all compiled files into main project (auto publishing)
mix.copyDirectory('public', '../../../public/vendor/jerome-savin/uccello-uitype-prefixed-number');