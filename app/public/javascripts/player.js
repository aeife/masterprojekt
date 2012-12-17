function Player (x, y, direction, color, username){
    this.color = color;
    this.fields = [];
    this.direction = direction;
    this.id = 0;
    this.host = false;
    this.username = username;

    this.ate = 0;

    //starting position
    this.spawnPlayer(x,y);
}

Player.prototype.spawnPlayer = function(x,y){
    this.fields = [];

    for (var i = 0; i < 3; i++){
        switch (this.direction){
            case "north":
                this.fields[i] = {x: x, y: y+2-i};
                level.grid[x][y+2-i].player = true;
                break;
            case "east":
                this.fields[i] = {x: x-2+i, y: y};
                level.grid[x-2+i][y].player = true;
                break;
            case "south":
                this.fields[i] = {x: x, y: y-2+i};
                level.grid[x][y-2+i].player = true;
                break;
            case "west":
                this.fields[i] = {x: x+2-i, y: y};
                level.grid[x+2-i][y].player = true;
                break;
        }
    }

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
    
    if (!this.checkCollision()){
        level.grid[this.fields[this.fields.length-1].x][this.fields[this.fields.length-1].y].player = true;
        level.drawTile(this.fields[this.fields.length-1].x, this.fields[this.fields.length-1].y, this.color);
    }

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
        return true;
    }

    return false;
}

Player.prototype.kill = function(disconnected){
    if (typeof disconnected === 'undefined'){
        disconnected = 0;
    }

    for (var i = 0; i < this.fields.length-disconnected; i++){
        level.grid[this.fields[i].x][this.fields[i].y].player = false;
        level.drawTile(this.fields[i].x, this.fields[i].y, 'white');
    }
    this.fields = [];

    var client = searchPlayerById(this.id);
    players.splice(players.indexOf(client), 1);
}

Player.prototype.eat = function(value){
    this.ate += value;
}

Player.prototype.isDead = function(){
    if (this.fields.length === 0)
        return true;
    return false;
}