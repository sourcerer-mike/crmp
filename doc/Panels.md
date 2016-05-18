# Panels

There are **panel groups** so that you can define new sections below your own entities.
And there are simple **panels** that can be added to an existing panel group.

## How to create a new panel group?

## How to create new panels for CRMP?

Register a new panel in your service.yml file.

    crmp.{targetEntity}.panel.{panelName}:
        class: Crmp\CrmBundle\Twig\Panel\FooPanel
        tags:
          - {name: 'crmp.panel', target: '{targetPanelGroup}' }

Fill out **targetEntity** with the entity that this panel relates to (e.g. "customer").
Place some unique name at **panelName** that describes the panel (e.g. "address_list").
The **class** should be the full class name of you own panel class (see below for the example).
At last the **targetPanelGroup** should be the name of an existing panel group like these:

- customer_related
- address_related

You can look them up by searching for the tag name 'crmp.panel_group' and looking for the tag alias like here:

    crmp.address.panels:
          class: Crmp\CrmBundle\Twig\PanelGroup
          tags:
            - { name: 'crmp.panel_group', alias: 'address_related' }

This is the definition of the panel group, that is usually shown below a single address.
The alias is 'address_related' so you can add new panels by using this for the target section:

    crmp.address.panel.character_rating:
        class: Crmp\NonsenseBundle\Twig\Panel\CharacterRatingPanel
        tags:
          - {name: 'crmp.panel', target: 'address_related' }

### Define the panel class

Your IDE will help you greatly using this panel template:

    class AddressPanel extends AbstractPanel implements PanelInterface
    {
        /**
         * Return a unique identifier among all known boardlets.
         *
         * @return string
         */
        public function getId()
        {
            return 'nonsense_character_rating';
        }
    
        /**
         * Return the name of this boardlet.
         *
         * @return string
         */
        public function getTitle()
        {
            return $this->container->get('translator')->trans('crmp.nonsense.character_rating.title');
        }
    }

### Change the template

In your class override this function from the AbstractPanel class:

    public function getTemplate()
    {
        return 'NonsenseBundle:Address:_panel-character-rating.html.twig';
    }

And the template may extend the default one like this:

    {% extends 'CrmBundle::panel.html.twig' %}
    
    {% block body %}
        This customer can have a car painted any colour that he wants so long as it is black.
    {% endblock %}
    

There are several more blocks to extend.
Please also have a look at the `CrmBundle::panel.html.twig` template.

### Serving data to the template

Simply override the `getData()` method and return an array of variable-names and values:

        public function getData()
        {
            if ($this->data) {
                // be lazy, reuse loaded data
                return (array) $this->data;
            }
    
            $this->data['character'] = ['common_sentence' => "I won't pay this."];
    
            return $this->data;
        }

Now you can access the `character.common_sentence` variable in the panel-template.