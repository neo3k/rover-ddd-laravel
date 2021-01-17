![Mars Rover](https://i.ibb.co/LzNKSnp/mars-rover.png)

This is my version of the Mars Rover kata in PHP (Laravel Framework), DDD and CQRS.

## 🚀 The Mission
You’re part of the team that explores Mars by sending remotely controlled vehicles to the surface of the planet. Develop a software that translates the commands sent from earth to instructions that are understood by the rover.

## ✅ Requirements

● You are given the initial starting point (x,y) of a rover and the direction (N,S,E,W)  it is facing.

● The rover receives a collection of commands. (E.g.) FFRRFFFRL

● The rover can move forward (f).

● The rover can move left/right (l,r).

● Suppose we are on a really weird planet that is square. 200x200 for example :)  

● Implement obstacle detection before each move to a new square. If a given  sequence of commands encounters an obstacle, the rover moves up to the last  possible point, aborts the sequence and reports the obstacle.

## 📖 How to use 
Install and run the application.

**Install**


```  
docker/up
docker/composer    
```
**CLI**
```  
docker/rover   
```
**Run Tests**
```  
docker/test  
```
