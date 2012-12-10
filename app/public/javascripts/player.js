function Player (x, y, color){
    this.color = color;
    this.fields = [];
    this.direction = "north";
    this.id = 0;
    this.host = false;

    this.ate = 0;

    //starting position
    this.spawnPlayer(x,y);
}

Player.prototype.spawnPlayer = function(x,y){
    this.fields = [];

    this.fields[3] = {x: x, y: y-2}
    level.grid[x][y-2].player = true;
    this.fields[2] = {x: x, y: y-1}
    level.grid[x][y-1].player = true;
    this.fields[1] = {x: x, y: y}
    level.grid[x][y].player = true;
    this.fields[0] = {x: x, y: y+1}
    level.grid[x][y+1].player = true;

    this.printPlayer();
}

Player.prototype.setHost = function(){
    this.host = true;
}

Player.prototype.printPlayer = function(){
    for (var i = 0; i < this.fields.length; i++){
        level.drawTile(this.fields[i].x, this.fields[i].y, this.color);
    }
}

Player.prototype.changeDirection = function(dir){
    switch (dir){
        case "north":
            if (this.direction != "south")
                this.direction = dir;
            break;
        case "east":
            if (this.direction != "west")
                this.direction = dir;
            break;
        case "south":
            if (this.direction != "north")
                this.direction = dir;
            break;
        case "west":
            if (this.direction != "east")
                this.direction = dir;
            break;
    }
}

Player.prototype.move = function(){


//array shift, delete last

    if (this.ate == 0){
        level.grid[this.fields[0].x][this.fields[0].y].player = false;
        level.drawTile(this.fields[0].x, this.fields[0].y, 'white');
        this.fields.shift();
    } else {
        this.ate--;
    }

    //new head, (switch direction)
    switch (this.direction){
        case "north":
            var newX = this.fields[this.fields.length-1].x;
            var newY = this.fields[this.fields.length-1].y-1;
            if (level.isInGrid(newX, newY)){
                this.fields.push({x: newX, y: newY});
            }
            else 
                this.fields.push({x: newX, y: level.gridSize-1});
            break;
        case "east":
            var newX = this.fields[this.fields.length-1].x+1;
            var newY = this.fields[this.fields.length-1].y;
            if (level.isInGrid(newX, newY))
                this.fields.push({x: newX, y: newY});
            else 
                this.fields.push({x: 0, y: newY});
            break;
        case "south":
            var newX = this.fields[this.fields.length-1].x;
            var newY = this.fields[this.fields.length-1].y+1;
            if (level.isInGrid(newX, newY))
                this.fields.push({x: newX, y: newY});
            else 
                this.fields.push({x: newX, y: 0});
            break;
        case "west":
            var newX = this.fields[this.fields.length-1].x-1;
            var newY = this.fields[this.fields.length-1].y;
            if (level.isInGrid(newX, newY))
                this.fields.push({x: newX, y: newY});
            else 
                this.fields.push({x: level.gridSize-1, y: newY});
            break;
    }
    
    this.checkCollision();

    level.grid[this.fields[this.fields.length-1].x][this.fields[this.fields.length-1].y].player = true;
    level.drawTile(this.fields[this.fields.length-1].x, this.fields[this.fields.length-1].y, this.color);

}

Player.prototype.checkCollision = function(){
    var headX = this.fields[this.fields.length-1].x;
    var headY = this.fields[this.fields.length-1].y;

    if (level.grid[headX][headY].food){
        this.eat(level.grid[headX][headY].food);
        level.grid[headX][headY].food = 0;
    }

    if (level.grid[headX][headY].player){
        this.kill(1);
        socket.emit('disconnect');
    }
}

Player.prototype.kill = function(disconnected){
    if (typeof disconnected === 'undefined'){
        disconnected = 0;
    }

    for (var i = 0; i < this.fields.length-disconnected; i++){
        level.grid[this.fields[i].x][this.fields[i].y].player = false;
        level.drawTile(this.fields[i].x, this.fields[i].y, 'white');
    }

    var client = searchPlayerById(this.id);
    players.splice(players.indexOf(client), 1);
}

Player.prototype.eat = function(value){
    this.ate += value;
}