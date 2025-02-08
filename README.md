Symfony AutomaticQueryBuilder Bundle
==========================

[![Latest Stable Version](http://poser.pugx.org/eltharin/autoqb/v)](https://packagist.org/packages/eltharin/autoqb) 
[![Total Downloads](http://poser.pugx.org/eltharin/autoqb/downloads)](https://packagist.org/packages/eltharin/autoqb) 
[![Latest Unstable Version](http://poser.pugx.org/eltharin/autoqb/v/unstable)](https://packagist.org/packages/eltharin/autoqb) 
[![License](http://poser.pugx.org/eltharin/autoqb/license)](https://packagist.org/packages/eltharin/autoqb)

Installation
------------

* Require the bundle with composer:

``` bash
composer require eltharin/autoqb
```

What is AutomaticQueryBuilder Bundle?
---------------------------
This bundle will create automatic custom queryBuilder (DQL) in repository.

Joins can be piloted by arguments without create one function each time joins are not the same.


How It Works ? 
---------------------------

First add AutoQbRepository trait in your repository.

This add getDQL() function and change findAll() :
```php
use Eltharin\AutomaticQueryBuilderBundle\Repository\AutoQbRepository;

class MyEntityRepository extends ServiceEntityRepository
{
    use AutoQbRepository;
    
    ....
}
```

Now you can use it.
---------------------------


Inline method
---------------------------

In a service you can call your repository and ask link directly in getDQL function : 

```php
    $dql = $myRepository->getDQL();
```

Considering $myRepository is ClassTest1 Entity Repository, DQL query will be : 
```sql
    SELECT classtest1 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
```
alias is tableName by default, or autoQBAlias property in repository or you can ether set in DQLOptions


you can pass a DqlOptions object to getDQL to ask relation :

```php
    $dql = $myRepository->getDQL((new DqlOptions)->with('classtest1__classtest2'));
```

Considering ClassTest1 as a relation to entity ClassTest2, DQL query will be :

```sql
    SELECT classtest1, classtest1__classtest2 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1 
    LEFT JOIN classtest1.classtest2 classtest1__classtest2
```

you can ask a relation from relation without request middle, that's automatic : 

```php
    $dql = $myRepository->getDQL((new DqlOptions)->with('classtest1__classtest2__classtest3'));
```

Considering ClassTest1 as a relation to entity ClassTest2, DQL query will be :

```sql
    SELECT classtest1, classtest1__classtest2, classtest1__classtest2__classtest3 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1 
    LEFT JOIN classtest1.classtest2 classtest1__classtest2 
    LEFT JOIN classtest1__classtest2.classtest3 classtest1__classtest2__classtest3
```

you find it's not enought automatic ? OK let's go for attributes

By properties attributes
---------------------------

You can also add attributes to your relations to make it more automatic, note you can have many attributes, the first compatible with your query will be taken : 

We can add a relation to ClassTest4 in our entity, and add a AutoQBField attribute,
with autolink at true, relation will be always taken.

```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(autoLink: true)]
    private ?ClassTest4 $classtest4 = null;
```

now if we execute getDQL : 
```php
    $dql = $myRepository->getDQL();
```

Considering $myRepository is ClassTest1 Entity Repository, DQL query will be :
```sql
    SELECT classtest1, classtest1__classtest4 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
    LEFT JOIN classtest1.classtest4 classtest1__classtest4
```

------

You can change the jointype : 

```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(autoLink: true, joinType: 'inner')]
    private ?ClassTest4 $classtest4 = null;
```

now if we execute getDQL :
```php
    $dql = $myRepository->getDQL();
```

Considering $myRepository is ClassTest1 Entity Repository, DQL query will be :
```sql
    SELECT classtest1, classtest1__classtest4
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
    INNER JOIN classtest1.classtest4 classtest1__classtest4
```

------

Automatic is good, but sometimes we want a relation only if root,

For example ClassTest1 have a manyToOne relation to ClassTest2 whitch have a manyToOne relation with ClassTest3

When we query ClassTest1 with ClassTest2 relation, we don't want have ClassTest3 automaticly but if we query ClassTest2 we want ever.

in ClassTest2 we add a AutoQbField attribute on ClassTest3 relation, add autolink and whenAlias arguments : 
```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(whenAlias: 'classtest2', autoLink: true)]
    private ?ClassTest3 $classtest3 = null;
```

```php
    $dql = $class1Repository->getDQL((new DqlOptions)->with('classtest1__classtest2'));
```
will be : 
```sql
    SELECT classtest1, classtest1__classtest2
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
    LEFT JOIN classtest1.classtest2 classtest1__classtest2
```
and
```php
    $dql = $class2Repository->getDQL();
```
will be :
```sql
    SELECT classtest2, classtest2__classtest3
    FROM EltharinAutoQBTests\Entity\ClassTest2 classtest2
    LEFT JOIN classtest2.classtest3 classtest2__classtest3
```

now imagine you have a property in ClassTest2 named "visible".
when you make a query on ClassTest1 you want have only classTest2 visible but in some circonstances, you want have all.

Remember, you can have many AutoQbField attributes : 

```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(relationAlias: 'classtest2All')]
    #[AutoQbField(conditionType: 'WITH', condition: '##alias##.visible = 1')]
    private ?ClassTest2 $classtest2 = null;
```

note we have set the relationAlias argument in first.

now : 
```php
    $dql = $class1Repository->getDQL((new DqlOptions)->with('classtest1__classtest2'));
```
will be :
```sql
    SELECT classtest1, classtest1__classtest2 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
    LEFT JOIN classtest1.classtest2 classtest1__classtest2 
        WITH classtest1__classtest2.visible = 1
```

and if we query the alias : 

```php
    $dql = $class1Repository->getDQL((new DqlOptions)->with('classtest1__classtest2All'));
```
will be :
```sql
    SELECT classtest1, classtest1__classtest2All 
    FROM EltharinAutoQBTests\Entity\ClassTest1 classtest1
    LEFT JOIN classtest1.classtest2 classtest1__classtest2All
```

you can also ask indexBy relation : 

```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(indexBy: 'idForIndexBy')]
    private ?ClassTest3 $classtest3 = null;
```
will be :
```sql
    SELECT mySuperAlias8, mySuperAlias8__classtest3 
    FROM EltharinAutoQBTests\Entity\ClassTest8 mySuperAlias8 
    LEFT JOIN mySuperAlias8.classtest3 mySuperAlias8__classtest3 
        INDEX BY mySuperAlias8__classtest3.idForIndexBy,
```

Now, IF you want more, you can make your own function in repository and call it : 

```php
    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[AutoQbField(callback: 'myCallbackInRepository')]
    private ?ClassTest4 $classtest4 = null;
```

```php
    public function myCallbackInRepository(QueryBuilder $qb, AssociationMapping $assoc, AutoQbField $propertyAttribute, string $alias, string $subAlias, $from = [], $count = 0, ?array $with = [])
    {
        $qb->andWhere($alias . '.property = :something')->setParameter('something', 'something');
    }
```

```sql
    SELECT mySuperAlias8, mySuperAlias8__classtest4 
    FROM EltharinAutoQBTests\Entity\ClassTest8 mySuperAlias8 
    LEFT JOIN mySuperAlias8.classtest4 mySuperAlias8__classtest4 
    WHERE mySuperAlias8.property = :something
```