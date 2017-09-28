# Drupal 8 Theme Installation
- Install the [helper module](https://github.com/adventistchurch/alps_drupal_helper)
- Download/extract contents into the themes folder within a subfolder such as `alps`. I.E. `themes/alps`
- Go to admin > appearance — click the "install and set as default" link.

## Theme Settings

### Block Layout and Menu Setup
- Primary menu 
  - Main navigation: Set "Maximum number of menu levels to display" to 2 to enable dropdowns and place the block in the `Primary menu` region. The primary menu displays below the global navigation. Also, when creating menu items check "show as expanded" if you'd always like the dropdown to be present. Otherwise, it will only show child items if you are on the parent page.
- Secondary menu
  - Global navigation: This is the navigation at the very top of the page. Create a menu called `Global Nav` and place the block in the `Secondary menu` region.
- Hero
  - This region was designed for a carousel. With the helper module installed, place the `homepage carousel` within this region.
- Full width first (optional)
- Primary first (optional)
- Breadcrumbs
  - Place `Breadcrumbs` block in the `Breadcrumb` region.
- Content first (optional)
- Content
  - Page title
  - Tabs
  - Help
  - Primary admin actions
  - Status messages
  - Main Page cotnent
- Content last (optional)
- Sidebar breakout
  - Blocks within this region get the "breakout" treatment.
- Sidebar
  - Place blocks in the `Sidebar` region if you'd like to utilize ALPS' sidebar theme. If you do not the page layout will default to the `single page` layout.
- Sidebar last (optional)
- Full width last (optional)
- Footer First
  - Footer menu: This is for footer menus, such as a list of social media links. Use the provided `footer` menu and place it here.
- Footer Second
  - Menu: Create a new menu called `Legal` and place it here to output links.

### Basic Page Setup
- Header Image (automatically added with helper module): If you create an image field with the machine name of field_header_image it will automatically be used as the header image. 
- Sub Title (automatically added with helper module): If you create a text field with the machine name of field_sub_title it will be utilized in the page header (underneath the main title) and within the homepage carousel view and news list/grid view(s).
- Regular Image Field: Image fields are style with a <figure> tag and additional ALPS theme markup. Additionally, if you would like to have a caption applied to your image, enable the title field and it will be used as the caption.


### Views
- Unformatted list: The default view output.
- Grid: You can only set the "Number of columns" to 2 or 3. It will default to a 3 column grid unless 2 is specified.
	You can remove the divider lines by adding the class `alps-without-divider` to the grid settings row or column custom class option. Click the Grid Settings link and then add it to the "Custom column class" or "Custom row class" field.
- Carousel (automatically added with helper module): Select an "unformatted list" and then add the tag "alps_carousel". View tags can be found vy clicking the "Edit viw name/description" link.
- Slide Alternate: Select an "unformatted list" and then add the tag "alps_slide_alternate". This will provide an ALPS slide markup that alternates back and forth such as:
Image | Content
Content | Image
Note that having an image present is key for this to work. The template will auto detect the image if the field name is `field_image` or `field_header_image`.

### Story Feature (automatically added with helper module)
- Image Style: You must create a new image style that **crops** and scales to a square format. Something like 200 x 200 works well. This is critical for the circular image style to work correctly. Cropping to a square is the most crucial aspect, but you should scale the image down as well.
- Templates: 
	templates/views/views-view-unformatted.html.twig
	templates/views/views-fields--alps-story.html.twig
- Via views: Select an "unformatted list" and then add the tag "alps_story". After adding your image field make sure you select the correct "square" image style from the previous step. The following fields are used for this view: title, image (or header image), body, sub title (optional), and "link to content" (optional).
- Background Image: There is a default/placeholder used for the blurry background image on story blocks. You can change this with custom css to override the background-image. i.e. `.story-block { background-image: url('/themes/alps/images/my-custom-image.png !important'); }`.

### Responsive Images
- Install the Responsive Images module. Go to `Extend`, select "Responsive Images", and click Install.
- Go to "Configuration" and select "Responsive Image Style".
- Edit narrow or wide and change the Breakpoint group to "ALPS Drupal 8 Theme".
- For each dropdown area, select "Select a single image style" and select an Image style that corresponds with the size of breakpoint you are in.
- Do not use a breakpoint for 1x Mobile. Instead use the option at the bottom "Fallback iamge style" as your mobile breakpoint style. "Max 325x325" is a good option.
- Now you can select "Responsive image" from the format dropdown.
