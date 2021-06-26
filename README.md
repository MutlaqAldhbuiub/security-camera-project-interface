# secuirty-camera-project-interface

## About
This **Web** project for the Embbdedd Programming class.
A website that contains your cameras, they're organized by something called "Application" to give you the ability to organize your camera by categories such as "Home, Work, ..etc." inside that you have your cameras. 
> It's ok to duplicate one camera to many Application (Category) 

## requirements
* Google "AIY" kit or anything you would like such as raspberry pi, jetson nano.
* Web server, checkout **deployment and use** section for more details.



## Deployment and Use

### Deployment
You must deploy this project to a server, or any static IP you have.
Feel free to use those providers or any provider you want. 
* [AWS](https://aws.amazon.com/)
* [DigitalOcean](https://www.digitalocean.com/)
* [Vultr](https://www.vultr.com/)

### After Deploy
after you finish deploy and configure the project, you should do more steps to connect your kit to the website.
#### Create a user.
Sign up for the website. (to get an API key)
#### Create an application
Click the *Create Application* button, Then enter any name you want e.g. "Home".
#### Create a camera!
Click the *Create Camera* button, Then you will see an alert that contains your *EndPoint*.
##### How to use this EndPoint?
Simply you can add this URL to the *Kit* project, and send the *Frame* to the website. and will be stored on your camera.   
