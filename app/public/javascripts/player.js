/*
 * # player.js
 *
 * Spielerobjekt inklusive aller Spielerfunktionalitäten
 */

 /*
 * ## Player
 *
 * Konstruktor des Spielerobjekts
 *
 * @param {int} x x-Koordinate des Spielers
 * @param {int} y y-Koordinate des Spielers
 * @param {string} direction Richtung des Spielers
 * @param {string} color Farbcode des Spielers
 * @param {string} username Nutzername des Spielers
 */
function Player (x, y, direction, color, username){
    this.color = color;
    this.fields = [];
    this.direction = direction;
    this.id = 0;
    this.host = false;
    this.username = username;

    this.ate = 0;

    this.spawnPlayer(x,y);
}

 /*
 * ## spawnPlayer
 *
 * Aufsetzen des Spielers
 *
 * @param {int} x x-Koordinate
 * @param {int} y y-Koordinate
 */
Player.prototype.spawnPlayer = function(x,y){
    this.fields = [];

    // Zeichnung des gesamten Spielerobjekts, ausgerichtet nach seiner Richtung
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

 /*
 * ## setHost
 *
 * Den Spieler als Host deklarieren
 */
Player.prototype.setHost = function(){
    this.host = true;
}

 /*
 * ## printPlayer
 *
 * Den Spieler zeichnen
 */
Player.prototype.printPlayer = function(){
    for (var i = 0; i < this.fields.length; i++){
        level.drawTile(this.fields[i].x, this.fields[i].y, this.color);
    }
}

 /*
 * ## changeDirection
 *
 * Richtungsänderung des Spielers
 *
 * @param {string} dir Neue Richtung
 */
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

 /*
 * ## move
 *
 * Den Spieler bewegen
 */
Player.prototype.move = function(){


    // Entfernen des letzten Spielerelements, nur wenn kein Essen mehr gespeichert
    // shift eines Arrays löscht letztes Feld
    if (this.ate == 0){
        level.grid[this.fields[0].x][this.fields[0].y].player = false;
        level.drawTile(this.fields[0].x, this.fields[0].y, 'white');
        this.fields.shift();
    } else {
        this.ate--;
    }

    // Hinzufügen des neuen Kopfs
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
    
    // Nur wenn keine Kollision: Eintragung und Zeichnung
    if (!this.checkCollision()){
        level.grid[this.fields[this.fields.length-1].x][this.fields[this.fields.length-1].y].player = true;
        level.drawTile(this.fields[this.fields.length-1].x, this.fields[this.fields.length-1].y, this.color);
    }

}

 /*
 * ## checkCollision
 *
 * Prüfung auf eine Kollision
 * mögliche Kollisionen mit Essen und anderen Spielern
 */
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

 /*
 * ## kill
 *
 * Töten eines Spielers
 *
 * @param {object} disconnected
 */
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

 /*
 * ## eat
 *
 * Aufnahme eines Essens
 *
 * @param {int} value Wert (in Kacheln) eines Essens
 */
Player.prototype.eat = function(value){
    this.ate += value;
}

 /*
 * ## isDead
 *
 * Prüfung ob Spieler tot ist (ob er keine Spielerelemente mehr hat)
 */
Player.prototype.isDead = function(){
    if (this.fields.length === 0)
        return true;
    return false;
}