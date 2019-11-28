# [task-001]

> We need a shortcode that will show a coupon submission form on the frontend so that admins can let other users add coupons to their site. The form will include all the fields that's available in the dashboard while adding a coupon. While adding a new coupon, some of the fields are hidden and shown conditionally. We will have to include those too. We will also have to make sure we follow security guidelines while creating, saving the form data.


## goals
- OOP design
    - may look odd when compared with the current code base, but will make testing and future improvements much easier
- testing
    - for fast releases
- documentation
    - document everything for future developers
 
## roadmap
seperating the task into three main subject

 - shortcode implementation
 - front-end form display
 - ~~embedding coupons at other sites~~
 
 ## todo
- [ ] tests
    > testing never ends, keep this segment unchecked
    - [x] tests' autoload should use project autoload
        - wrote a test specific autoload for project files that works in pair with vendor autoloads
    - > disabled front-end tests for now since `jest` is giving problems with the latest `@babel/core`, and I don't want to downgrade the most recent/secure version, will look for a solution later. for now `console.log` is my best friend
- [x] short code class
    - [x] necessary sub classes
- [ ] front-end form display
    - [x] extract form fields from already defined `add new coupon` form meta box
    - [x] modern front-end compiler (`webpack`)
        - [x] `vuejs` integration
    - [ ] responsive field display based on `coupon types` and other dynamic fields
        - [x] add a better template change module for changing different template types for better performance
        - [ ] full filter array for all the dependent fields (do it off-clock since we will just gonna write down each visible/hidden field id depending on template/other fields)
    - [ ] WYSIWYG coupon display
        - [ ] ~~have to write a parser for different coupon templates that has defined in the server code to reflect the same coupon look and feel in frontend & to reflect any changes that has done or any new template added~~
            - [x]since the relation of coupon preview and its styles are inlined heavily inside server side php code, will gonna use that classes to extract the necessary values to reflect that data
                - [ ] extracting that may have caused some volatile admin data to leak to front-end. have to check the code line by line to avoid such scenario
    - [ ] form style
        - [x] for development, use `tailwindcss`
        - [ ] ~~experiment with a admin side settings page for various form style options to give out of the box and customizable form display~~
             - > giving that kind of customization option for form display may hurt some front-ends, instead users should override the form style according to the look and feel of their site. will give logical class names for form elements so that they can be customized by end user with their **own** stylesheets.
            -  > will gonna style the form in a more material style way so out of the box, it will gonna look more native with any site 
- [ ] release
    - [ ] cleanup
        - [ ] node_modules
        - [ ] composer packages
        - [ ] markdowns
        - [ ] `TODO` comments tagged with `[task-001]`
     - [ ] production build of any `files`
        - [ ] check if they are `minified`
