function Menu(dom){
        var self=this;
        self.dom = $(dom);

        function setup(){
            if(self.dom.length == 0)
                return;
            $('.heading',self.dom).click(function(){
                console.log(self.dom);
                console.log(self.dom.hasClass('open'));
                if(self.dom.hasClass('open')){
                    self.dom.removeClass('open')
                    return;
                }
                self.dom.addClass('open');
            });
        }

        setup();
}

new Menu(document.getElementById('menu'));
