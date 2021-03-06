
/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */
/* changes by coster alpstein austria */

/**
 * @extends YAHOO.util.DragDrop
 * @constructor
 * @param {String} handle the id of the element that will cause the resize
 * @param {String} panel id of the element to resize
 * @param {String} sGroup the group of related DragDrop items
 */
YAHOO.example.DDResize = function(panelElId, handleElId, sGroup, config) {
    if (panelElId) {
        this.init(panelElId, sGroup, config);
        this.handleElId = handleElId;
        this.setHandleElId(handleElId);
        this.logger = this.logger || YAHOO;
    }
};

// YAHOO.example.DDResize.prototype = new YAHOO.util.DragDrop();
YAHOO.extend(YAHOO.example.DDResize, YAHOO.util.DragDrop);

YAHOO.example.DDResize.prototype.onMouseDown = function(e) {
    var panel = this.getEl();
    this.startWidth = panel.offsetWidth;
    this.startHeight = panel.offsetHeight;

    this.startPos = [YAHOO.util.Event.getPageX(e),
                     YAHOO.util.Event.getPageY(e)];
                     
};

YAHOO.example.DDResize.prototype.onDrag = function(e) {
	
	//coster: x y auslesen:
	var x = YAHOO.util.Event.getPageX(e);
	var y = YAHOO.util.Event.getPageY(e);

    var newPos = [x,y];

    var offsetX = newPos[0] - this.startPos[0];
    var offsetY = newPos[1] - this.startPos[1];

    var newWidth = Math.max(this.startWidth + offsetX, 10);
    var newHeight = Math.max(this.startHeight + offsetY, 10);

    var panel = this.getEl();
    panel.style.width = newWidth + "px";
    panel.style.height = newHeight + "px";
    
    //coster: setzten der position und groesse in den formfeldern f�r speicherung:
    document.breiteHoehe.hoehe.value = newHeight;
    document.breiteHoehe.breite.value = newWidth;
    document.tischbild.width = newWidth;    
    document.tischbild.height = newHeight;
    //coster: raumbild verschiebt sich bei skalierung ...
    // ... raumbild fixieren:
	var DOM = YAHOO.util.Dom;
	var raumPos = DOM.getXY("positionieren");
	DOM.setXY(raumbild,raumPos);

};