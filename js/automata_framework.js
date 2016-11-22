function Node(data) {
    this.data = data;
    this.id = 0;
    this.parent = [];
    this.children = [];
}

function Tree(data) {
    var node = new Node(data);
    this._root = node;
}

// root
var tree = new Tree('R');


// depth-first traversal
// traverseDF(callback)
Tree.prototype.traverseDF = function(callback) {
 
    // this is a recurse and immediately invoking function 
    (function recurse(currentNode) {
        for (var i = 0, length = currentNode.children.length; i < length; i++) {
            recurse(currentNode.children[i]);
        }
        callback(currentNode);
    })(this._root);
 
};

// breadth-first search
// traverseBF(callback)
Tree.prototype.traverseBF = function(callback) {
    var queue = new Queue();
     
    currentTree = this._root;
 
    while(currentTree){
        for (var i = 0, length = currentTree.children.length; i < length; i++) {
            queue.enqueue(currentTree.children[i]);
        }
 
        callback(currentTree);
        currentTree = queue.dequeue();
    }
};

// contains(callback, traversal)
Tree.prototype.contains = function(callback, traversal) {
    traversal.call(this, callback);
};

// add(data, toData, toId, traversal)
Tree.prototype.add = function(data, id, toData, toId, traversal) {
    var child = new Node(data),
        parent = null,
        callback = function(node) {
            if (node.data === toData && node.id === toId) {
                parent = node;
            }
        };
 
    this.contains(callback, traversal);
 
    if (parent) {
        child.id = id;
        parent.children.push(child);
        child.parent.push(parent);
    } else {
        throw new Error('Cannot add node to a non-existent parent.');
    }
};

// connectNodes(cData, cId, pData, pId, traversal)
Tree.prototype.connectNodes = function(cData, cId, pData, pId, traversal) {
    var parent = null,
        child = null;
        
    // find parent    
    var callback = function(node) {
        if (node.data === pData && node.id === pId) {
            parent = node;
        }
    }
    this.contains(callback, traversal);
    
    // find child
    callback = function(node) {
        if (node.data === cData && node.id === cId) {
            child = node;
        }
    }
    this.contains(callback, traversal);
    
    if(parent){
        if(child){
            parent.children.push(child);
            child.parent.push(parent);
        } else {
            throw new Error('Cannot connect node to a non-existent child.');
        }
    } else {
        throw new Error('Cannot connect node to a non-existent parent.');
    }
};

// removeParent(cData, cId, pData, pId, traversal)
Tree.prototype.removeParent = function(cData, cId, pData, pId, traversal){
    var child = null,
        parentToRemove = null;
    
    // find child
    var callback = function(node) {
        if (node.data === cData && node.id === cId) {
            child = node;
        }
    }
    this.contains(callback, traversal);
    
    if(child){
        index = findIndex(child.parent,pData,pId);
        if (index === undefined) {
            throw new Error('Node to remove does not exist.');
        } else {
            parentToRemove = child.parent.splice(index, 1);
        }
    } else {
        throw new Error('Child does not exist.');
    }
    return parentToRemove;
};

// remove(data, id, fromData, fromId, traversal)
Tree.prototype.remove = function(data, id, fromData, fromId, traversal) {
    var tree = this,
        parent = null,
        childToRemove = null,
        index;
 
    var callback = function(node) {
        if (node.data === fromData && node.id === fromId) {
            parent = node;
        }
    };
 
    this.contains(callback, traversal);
 
    if (parent) {
        index = findIndex(parent.children, data, id);
 
        if (index === undefined) {
            throw new Error('Node to remove does not exist.');
        } else {
            childToRemove = parent.children.splice(index, 1);
            
        }
    } else {
        throw new Error('Parent does not exist.');
    }
    
    
    return childToRemove;
};

function findIndex(arr, data, id) {
    var index;
 
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].data === data && arr[i].id === id) {
            index = i;
        }
    }
 
    return index;
}

// queue

function Queue() {
    this._oldestIndex = 1;
    this._newestIndex = 1;
    this._storage = {};
}
 
Queue.prototype.size = function() {
    return this._newestIndex - this._oldestIndex;
};
 
Queue.prototype.enqueue = function(data) {
    this._storage[this._newestIndex] = data;
    this._newestIndex++;
};
 
Queue.prototype.dequeue = function() {
    var oldestIndex = this._oldestIndex,
        newestIndex = this._newestIndex,
        deletedData;
 
    if (oldestIndex !== newestIndex) {
        deletedData = this._storage[oldestIndex];
        delete this._storage[oldestIndex];
        this._oldestIndex++;
 
        return deletedData;
    }
};

//test
// tree.add('A', 0, 'R', 0, tree.traverseBF);
// tree.add('B', 0, 'A', 0, tree.traverseBF);
// tree.add('B', 1, 'A', 0, tree.traverseBF);
// console.log(tree._root.children[0]);
// tree.connectNodes('B', 0, 'R', 0, tree.traverseBF);
// var a = tree.remove('A', 0, 'R', 0, tree.traverseBF);
// var b = tree.removeParent('B', 0, 'A', 0, tree.traverseBF);
// console.log(tree._root.children);