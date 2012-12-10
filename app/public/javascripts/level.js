var level = {
	grid: [],
	gridSize: 50,
	tileSize: 10,
	initializeGrid: function(){
		for (var i = 0; i < this.gridSize; i++) {
		    this.grid[i] = [];
		    for (var j = 0; j < this.gridSize; j++){
		        this.grid[i][j] = {food: 0, player: false};
		    }
		}
	},
	printGrid: function(){
		for (var x = 0; x < this.gridSize; x++){
	        for (var y = 0; y < this.gridSize; y++){
	            this.drawTile(x, y, 'white');
	        }
	    }
	},
	isInGrid: function(x, y){
		if (x < 0 || x >= this.gridSize || y < 0 || y >= this.gridSize){
	        return false;
	    } else{
	        return true;
	    }
	},
	drawTile: function(x, y, color){
		ctx.fillStyle = color;
    	ctx.fillRect(x*this.tileSize, y*this.tileSize, this.tileSize, this.tileSize);
    
    	ctx.strokeStyle = "#F2F2F2";
    	ctx.strokeRect(x*this.tileSize, y*this.tileSize, this.tileSize, this.tileSize);
	},
	generateFood: function(x, y){
	    this.grid[x][y] = {food: 5};
	    this.drawTile(x, y, 'black');
	}
}