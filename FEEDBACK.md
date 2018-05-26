# Feedback for Boxalino Magento 1.x v2 plug-in

## Introduction
I added some comments in a few commits in the code. You will find my commits right [here](https://github.com/JonasMoltke/boxalinoFeedback/commits?author=Jonassinful).

## Feedback

##### fetchAll
I see that fetchAll is used in some areas. fetchAll raises execution time and raises the possibility for running out of memory aswell as gives CPU spikes.

Example: [Model/Mysql4/Indexer.php Line 882-886](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/Model/Mysql4/Indexer.php#L882-#L886)

The better solution:
```
$result = $db->query($select);  
 
while($row = $result->fetch()) {
            
    $row['entity_id'] = 'duplicate'.$row['entity_id'];
    $data[] = $row;
            
}
```

##### Looping SQL queries
SQL queries inside loops is quite bad practice as the query will run for every iteration. The better solution (also to avoid memory exceeding), would be loading the query before the loop

Example: [Block/Recommendation.php Line 173-180](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/Block/Recommendation.php#L173-L180)

The better (and lightweight) solution:
```
$_orderItems = $order->getAllItems();  
 
foreach ($_orderItems as $item) {  
 
    if ($item->getPrice() > 0) { 
    
        $product = $item->getProduct();  
 
        if ($product) {
            $context[] = $product;
        }
        
    }  
 
}
```

##### Caching
So we went a little over the possibility of caching part of the module \
I think this is something that should be played a little around with

I definely see the possibility of caching parts of the extension. This could probably be achieved at places like:
- Block/Banner.php
- Block/BlogResult.php
- Block/Landingpage.php
- Block/Slider.php

And probably more places. This is something to be played around with. This could either be achieved by using ``$this->addData`` in the constructor or ``Mage::app()->getCache()`` with load and save events.

#### Double quotes vs. single quotes
- I noticed that double quotes is used quite alot.
- Single quotes should be used instead as double quotes will search for variables within the string, so single quotes can be ran up to five times faster
- This should be implemented in foreach loops at least
- Does not have a huge impact, but everything counts

#### Public vs procted block constructors
In almost any case the block ``_constructor`` functions should be defined as protected, but i see that its quite the opposite in this extension.

#### Javascript optimization
I really think that compiling boxalinoFacets.js and boxalinoAutocomplete.js with **Google Closure Compiler** could help the browser performance alot.

https://closure-compiler.appspot.com/home

#### Documentation
Ok, so im not the biggest fan of documentation overkill but it does become handy.
 ```
 public function setSetup($setup){  
  
      $this->setup = $setup;
      
 }
 ```
 
Something like that does not really help much to document. But take a look at a file like this file:
[lib/BxClient.php](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/lib/BxClient.php)

Lots of logic happens, but not really any documentation on what it does. It does indeed make it easier for developers to understand each others code with a little explanation of the functions, classes and events/actions fired.

For starters @package, @category, @module and @author and description for larger features would be nice.

#### Code cleanup

Its kind of easy to see that several developers have been over this repository. \
In some files the code is very readable, has perfect indents and spacing. Other files and functions like those:
- [lib/BxClient.php line 395](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/lib/BxClient.php#L395)
- [lib/BxClient.php line 531](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/lib/BxClient.php#L531)
- [lib/Thrift/Base/TBase.php](https://github.com/boxalino/plugin-magento1-v2/blob/master/app/code/community/Boxalino/Intelligence/lib/Thrift/Base/TBase.php)

Really needs some indents and line breaks in order to get a better and quicker overview.\
Also i find this important because its a open source and really should be code you can be proud of showing.



#### Thoughts

I will admit this is a whole new way of programming in Magento for me as you combine the best and most necessary of Magento with native PHP to boost performance 

Normally this would be considered bad practice, but i really do see why it can be so effective for speeding up the system avoiding the use of Magento's data set aswell as the Zend and Varien framework as much as possible.

I do find it quite interesting and exciting working this way as im a huge fan of both the Magento framework and native PHP.

I'm "happy" to see so many functions and views that performance wise could be improved.