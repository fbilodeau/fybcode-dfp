<?php

namespace Fybcode\DfpBundle\Model;

use Countable, IteratorAggregate, ArrayAccess, Closure, ArrayIterator;

/**
 * Lovingly stolen from the Doctrine Common project.
 *
 * @see https://github.com/doctrine/common/blob/master/lib/Doctrine/Common/Collections/ArrayCollection.php
 *
 * A Collection resembles the nature of a regular PHP array. That is,
 * it is essentially an <b>ordered map</b> that can also be used
 * like a list.
 * 
 * A Collection has an internal iterator just like a PHP array. In addition,
 * a Collection can be iterated with external iterators, which is preferrable.
 * To use an external iterator simply use the foreach language construct to
 * iterate over the collection (which calls {@link getIterator()} internally) or
 * explicitly retrieve an iterator though {@link getIterator()} which can then be
 * used to iterate over the collection.
 * You can not rely on the internal iterator of the collection being at a certain
 * position unless you explicitly positioned it before. Prefer iteration with
 * external iterators.
 *
 * @package     FybcodeDfpBundle
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 * @author      Francis Bilodeau <fbilodeau@dessinsdrummond.com>
 * @copyright   (c) 2017 Francis Bilodeau
 */

class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    private $collection;

    /**
     * Initializes a new AdCollection.
     *
     * @param array $collection
     */
    public function __construct(array $collection = array())
    {
        $this->collection = $collection;
    }

    /**
     * Gets the PHP array representation of this collection.
     *
     * @return array The PHP array representation of this collection.
     */
    public function toArray()
    {
        return $this->collection;
    }

    /**
     * Sets the internal iterator to the first element in the collection and
     * returns this element.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->collection);
    }

    /**
     * Sets the internal iterator to the last element in the collection and
     * returns this element.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->collection);
    }

    /**
     * Gets the current key/index at the current internal iterator position.
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->collection);
    }
    
    /**
     * Moves the internal iterator position to the next element.
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->collection);
    }
    
    /**
     * Gets the element of the collection at the current internal iterator position.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Removes an element with a specific key/index from the collection.
     *
     * @param mixed $key
     * @return mixed The removed element or NULL, if no element exists for the given key.
     */
    public function remove($key)
    {
        if (isset($this->collection[$key])) {
            $removed = $this->collection[$key];
            unset($this->collection[$key]);
            
            return $removed;
        }

        return null;
    }

    /**
     * Removes the specified element from the collection, if it is found.
     *
     * @param mixed $element The element to remove.
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->collection, true);
        
        if ($key !== false) {
            unset($this->collection[$key]);
            
            return true;
        }
        
        return false;
    }

    /**
     * ArrayAccess implementation of offsetExists()
     *
     * @see containsKey()
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see get()
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess implementation of offsetGet()
     *
     * @see add()
     * @see set()
     */
    public function offsetSet($offset, $value)
    {
        if ( ! isset($offset)) {
            return $this->add($value);
        }
        return $this->set($offset, $value);
    }

    /**
     * ArrayAccess implementation of offsetUnset()
     *
     * @see remove()
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * Checks whether the collection contains a specific key/index.
     *
     * @param mixed $key The key to check for.
     * @return boolean TRUE if the given key/index exists, FALSE otherwise.
     */
    public function containsKey($key)
    {
        return isset($this->collection[$key]);
    }

    /**
     * Checks whether the given element is contained in the collection.
     * Only element values are compared, not keys. The comparison of two elements
     * is strict, that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $element
     * @return boolean TRUE if the given element is contained in the collection,
     *          FALSE otherwise.
     */
    public function contains($element)
    {
        return in_array($element, $this->collection, true);
    }

    /**
     * Tests for the existance of an element that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE if the predicate is TRUE for at least one element, FALSE otherwise.
     */
    public function exists(Closure $p)
    {
        foreach ($this->collection as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Searches for a given element and, if found, returns the corresponding key/index
     * of that element. The comparison of two elements is strict, that means not
     * only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $element The element to search for.
     * @return mixed The key/index of the element or FALSE if the element was not found.
     */
    public function indexOf($element)
    {
        return array_search($element, $this->collection, true);
    }

    /**
     * Gets the element with the given key/index.
     *
     * @param mixed $key The key.
     * @return mixed The element or NULL, if no element exists for the given key.
     */
    public function get($key)
    {
        if (isset($this->collection[$key])) {
            return $this->collection[$key];
        }
        return null;
    }

    /**
     * Gets all keys/indexes of the collection elements.
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->collection);
    }

    /**
     * Gets all elements.
     *
     * @return array
     */
    public function getValues()
    {
        return array_values($this->collection);
    }

    /**
     * Returns the number of elements in the collection.
     *
     * Implementation of the Countable interface.
     *
     * @return integer The number of elements in the collection.
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * Adds/sets an element in the collection at the index / with the specified key.
     *
     * When the collection is a Map this is like put(key,value)/add(key,value).
     * When the collection is a List this is like add(position,value).
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }

    /**
     * Adds an element to the collection.
     *
     * @param mixed $value
     * @return boolean Always TRUE.
     */
    public function add($value)
    {
        $this->collection[] = $value;
        return true;
    }

    /**
     * Checks whether the collection is empty.
     * 
     * Note: This is preferrable over count() == 0.
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty()
    {
        return ! $this->collection;
    }

    /**
     * Gets an iterator for iterating over the elements in the collection.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * Applies the given function to each element in the collection and returns
     * a new collection with the elements returned by the function.
     *
     * @param Closure $func
     * @return Collection
     */
    public function map(Closure $func)
    {
        return new static(array_map($func, $this->collection));
    }

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     * @return Collection A collection with the results of the filter operation.
     */
    public function filter(Closure $p)
    {
        return new static(array_filter($this->collection, $p));
    }

    /**
     * Applies the given predicate p to all elements of this collection,
     * returning true, if the predicate yields true for all elements.
     *
     * @param Closure $p The predicate.
     * @return boolean TRUE, if the predicate yields TRUE for all elements, FALSE otherwise.
     */
    public function forAll(Closure $p)
    {
        foreach ($this->collection as $key => $element) {
            if ( ! $p($key, $element)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Partitions this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param Closure $p The predicate on which to partition.
     * @return array An array with two elements. The first element contains the collection
     *               of elements where the predicate returned TRUE, the second element
     *               contains the collection of elements where the predicate returned FALSE.
     */
    public function partition(Closure $p)
    {
        $coll1 = $coll2 = array();
        foreach ($this->collection as $key => $element) {
            if ($p($key, $element)) {
                $coll1[$key] = $element;
            } else {
                $coll2[$key] = $element;
            }
        }
        return array(new static($coll1), new static($coll2));
    }

    /**
     * Returns a string representation of this object.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    /**
     * Clears the collection.
     */
    public function clear()
    {
        $this->collection = array();
    }

    /**
     * Extract a slice of $length elements starting at position $offset from the Collection.
     *
     * If $length is null it returns all elements from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the elements contained in the collection slice is called on.
     *
     * @param int $offset
     * @param int $length
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->collection, $offset, $length, true);
    }
}
