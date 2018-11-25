class CanvasLocations {
    constructor() {
        this.rowStarts = [];
        this.columnStarts = [];
        this.rowHeight = 0;
        this.columnWidth = 0;
        this.leftOffset = 0;
        this.rightOffset = 0;
        this.topOffset = 0;
        this.bottomOffset = 0;
        this.pixelHeight = 0;
        this.pixelWidth = 0;
    }

    addRow(rowLocation){
        this.rowStarts.push(rowLocation);
    }

    addColumn(columnLocation){
        this.columnStarts.push(columnLocation);
    }

}

export default (new CanvasLocations);