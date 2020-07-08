'use strict';

//Polyfill for browsers that do not support Element.closest()
if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector || 
                                Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
    Element.prototype.closest = function(s) {
    var el = this;

    do {
        if (el.matches(s)) return el;
        el = el.parentElement || el.parentNode;
    } while (el !== null && el.nodeType === 1);
    return null;
    };
}

  
window.onload = function(e){

    function getCORS(url, success) {
        var xhr = new XMLHttpRequest();
        if (!('withCredentials' in xhr)) xhr = new XDomainRequest(); // fix IE8/9
        xhr.open('GET', url);
        xhr.onload = success;
        xhr.send();
        return xhr;
    }

    //Number formatting
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    var removeComma = function(str){
        return str.replace(/,/g, '').trim();
    }

    var colors = document.getElementsByClassName('color');
    for(var i = 0, len = colors.length; i < len; i++){
        colors[i].addEventListener('click', function(){

            var vote = this.closest("tr").getElementsByClassName('vote')[0]; 
            if(vote.innerHTML != ''){
                vote.innerHTML = '';
            }else{
                getCORS('?color=' + this.innerHTML, function(request){
                    var response = request.currentTarget.response || request.target.responseText;
                    var votes = JSON.parse(response);
                    vote.innerHTML = votes.length == 0? 0 : formatNumber(votes);
                });
            } 
        });
    }

    document.getElementById('total').addEventListener('click', function(){
        var votes = document.getElementsByClassName('vote');
        var sum = 0;
        for(var i = 0, len = votes.length; i < len; i++){
            if(parseInt(removeComma(votes[i].innerHTML))){
                sum = parseInt(sum) + parseInt(removeComma(votes[i].innerHTML));
            }
        }
        document.getElementById('result').innerHTML = formatNumber(sum);
    });
  
}