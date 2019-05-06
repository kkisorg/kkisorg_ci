/**
//TextLimiter by Jean-Nicolas Jolivet
//Copyright (c) 2008 http://www.silverscripting.com
//MIT License:  http://www.opensource.org/licenses/mit-license.php
**/

var TextLimiter = function (el, options) {
    this.message = options.message || " chars left";
    this.el = (typeof el === 'string') ? document.getElementById(el) : el;
    this.charLimit = options.charLimit || 100;
    this.interval = options.interval || 200;
    this.addLineBreak = options.addLineBreak || true;
 
    this.buildElements();
 
};
 
TextLimiter.prototype.buildElements = function() {
    var parentEl = this.el.parentNode;
    var that = this;
 
    this.charCountEl = document.createElement('span');
    this.charCountEl.className = 'textlimiter';
    this.charCountEl.innerHTML = this.charLimit + this.message;
    if(this.addLineBreak) {
        var lineBreak = document.createElement('br');
        parentEl.insertBefore(lineBreak, this.el.nextSibling);
        parentEl.insertBefore(this.charCountEl, lineBreak.nextSibling);
    }
    else {
        parentEl.insertBefore(this.charCountEl, this.el.nextSibling);
    }
    this.oldCharCount = this.el.value.length;
    this.el.onfocus = function() {
        that.intervalTimer = setInterval(function(){that.dispatchChangeEvent();}, that.interval);
    };
 
    this.el.onblur = function() {
        clearTimeout(that.intervalTimer);
    };
 
};
 
TextLimiter.prototype.dispatchChangeEvent = function() {
    if(this.oldCharCount != this.el.value.length) {
 
        var newCharCount = this.el.value.length;
        var charCnt = this.charLimit - newCharCount;
        if (charCnt <= 0) {
            this.el.value = this.el.value.substr(0, this.charLimit);
            charCnt = 0;
        }
        this.charCountEl.innerHTML = charCnt + this.message;
    }
    this.oldCharCount = this.el.value.length;
};

