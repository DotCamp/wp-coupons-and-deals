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
 - embedding coupons at other sites
 
 ## todo
- [ ] tests
    > testing never ends, keep this segment unchecked
    - [x] tests autoload should use project autoload
    - wrote test specific autoload for project files that works in pair with vendor autoloads
- [ ] short code class
    - [ ] necessary sub classes
- [ ] front-end form display
    - [x] extract form fields from already defined `add new coupon` form meta box
    - [ ] `vuejs` integration
    - [ ] WYSIWYG coupon display
    - [ ] form style
        - [ ] for development, use `tailwindcss`
        - [ ] experiment with a admin side settings page for various form style options to give out of the box and customizable form display
