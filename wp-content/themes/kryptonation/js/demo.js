jQuery(function($){
    var slider = window.slider = new Slider($('#demo'));
slider.fetchJson('photos.json')
slider.setSize(640, 400);
slider.setTheme('theme-dark');
slider.setTransition('transition-oblique');
});
