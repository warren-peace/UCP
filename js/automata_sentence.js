// root
var tree = new Tree('START');

// level 0
 tree.add('V', 0, 'START', 0, tree.traverseBF);
 tree.add('Adj', 0, 'START', 0, tree.traverseBF);
 tree.add('Adv', 0, 'START', 0, tree.traverseBF);
 
// level 1
 tree.add('N', 1, 'V', 0, tree.traverseBF);
 tree.add('P', 1, 'V', 0, tree.traverseBF);
 tree.add('V', 1, 'V', 0, tree.traverseBF);
 tree.add('C', 1, 'Adj', 0, tree.traverseBF);
 tree.add('Prep', 1, 'Adv', 0, tree.traverseBF);
 tree.add('Prep', 10, 'V', 0, tree.traverseBF);
 tree.connectNodes('N', 1, 'C', 1, tree.traverseBF);
 tree.connectNodes('N', 1, 'Prep', 10, tree.traverseBF);
 tree.connectNodes('V', 1, 'Adj', 0, tree.traverseBF);
 tree.connectNodes('V', 1, 'Adv', 0, tree.traverseBF);

// level 2
 tree.add('N', 2, 'N', 1, tree.traverseBF);
 tree.add('N', 20, 'Prep', 1, tree.traverseBF);
 tree.add('Prep', 2, 'P', 1, tree.traverseBF);
 tree.connectNodes('N', 2, 'Prep', 2, tree.traverseBF);
 tree.connectNodes('N', 20, 'Prep', 2, tree.traverseBF);
 tree.connectNodes('N', 2, 'V', 1, tree.traverseBF);
 tree.connectNodes('N', 2, 'V', 0, tree.traverseBF);
 tree.connectNodes('N', 2, 'P', 1, tree.traverseBF);
 tree.connectNodes('N', 2, 'Adj', 0, tree.traverseBF);
 tree.connectNodes('Prep', 2, 'V', 0, tree.traverseBF);
 
// end
 tree.add('END', 0, 'P', 1, tree.traverseBF);
 tree.connectNodes('END', 0, 'N', 2, tree.traverseBF);
 tree.connectNodes('END', 0, 'V', 0, tree.traverseBF);

 tree.traverseBF(function(node) {
    console.log(node.data)
});