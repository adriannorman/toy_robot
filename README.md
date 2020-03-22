Toy Robot Simulator
===================

Description
-----------

The application is a simulation of a toy robot moving on a square tabletop, of dimensions 5 units x 5 units.
  
To run the app, enter the following into your UNIX/UNIX-like shell:

    php app.php

Commands
-----------
   
You can navigate around the table using the following commands. 

*Please be aware that any commands prior to the PLACE command will be ignored!*

    PLACE X,Y,F
    
Place's the robot on the table at coordinates (X,Y), and facing direction F.

Note that the table's coordinates are zero-indexed, so the robot needs to be positioned between coordinates (0,0) and (4,4) inclusive.

Allowed directions:

- NORTH
- SOUTH
- EAST
- WEST


    MOVE
    
Moves the robot by 1 unit in the direction it's facing after placement upon the table.
    
    LEFT
    
Turns the robot 90 degrees counter clockwise after being placed on the table.

    RIGHT

Turns the robot 90 degrees clockwise after being placed on the table.
    
    REPORT
    
Provides information on the robot's location and direction relative to the table.
