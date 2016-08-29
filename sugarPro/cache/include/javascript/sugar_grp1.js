//     Underscore.js 1.4.4
//     http://underscorejs.org
//     (c) 2009-2013 Jeremy Ashkenas, DocumentCloud Inc.
//     Underscore may be freely distributed under the MIT license.

(function() {

  // Baseline setup
  // --------------

  // Establish the root object, `window` in the browser, or `global` on the server.
  var root = this;

  // Save the previous value of the `_` variable.
  var previousUnderscore = root._;

  // Establish the object that gets returned to break out of a loop iteration.
  var breaker = {};

  // Save bytes in the minified (but not gzipped) version:
  var ArrayProto = Array.prototype, ObjProto = Object.prototype, FuncProto = Function.prototype;

  // Create quick reference variables for speed access to core prototypes.
  var push             = ArrayProto.push,
      slice            = ArrayProto.slice,
      concat           = ArrayProto.concat,
      toString         = ObjProto.toString,
      hasOwnProperty   = ObjProto.hasOwnProperty;

  // All **ECMAScript 5** native function implementations that we hope to use
  // are declared here.
  var
    nativeForEach      = ArrayProto.forEach,
    nativeMap          = ArrayProto.map,
    nativeReduce       = ArrayProto.reduce,
    nativeReduceRight  = ArrayProto.reduceRight,
    nativeFilter       = ArrayProto.filter,
    nativeEvery        = ArrayProto.every,
    nativeSome         = ArrayProto.some,
    nativeIndexOf      = ArrayProto.indexOf,
    nativeLastIndexOf  = ArrayProto.lastIndexOf,
    nativeIsArray      = Array.isArray,
    nativeKeys         = Object.keys,
    nativeBind         = FuncProto.bind;

  // Create a safe reference to the Underscore object for use below.
  var _ = function(obj) {
    if (obj instanceof _) return obj;
    if (!(this instanceof _)) return new _(obj);
    this._wrapped = obj;
  };

  // Export the Underscore object for **Node.js**, with
  // backwards-compatibility for the old `require()` API. If we're in
  // the browser, add `_` as a global object via a string identifier,
  // for Closure Compiler "advanced" mode.
  if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
      exports = module.exports = _;
    }
    exports._ = _;
  } else {
    root._ = _;
  }

  // Current version.
  _.VERSION = '1.4.4';

  // Collection Functions
  // --------------------

  // The cornerstone, an `each` implementation, aka `forEach`.
  // Handles objects with the built-in `forEach`, arrays, and raw objects.
  // Delegates to **ECMAScript 5**'s native `forEach` if available.
  var each = _.each = _.forEach = function(obj, iterator, context) {
    if (obj == null) return;
    if (nativeForEach && obj.forEach === nativeForEach) {
      obj.forEach(iterator, context);
    } else if (obj.length === +obj.length) {
      for (var i = 0, l = obj.length; i < l; i++) {
        if (iterator.call(context, obj[i], i, obj) === breaker) return;
      }
    } else {
      for (var key in obj) {
        if (_.has(obj, key)) {
          if (iterator.call(context, obj[key], key, obj) === breaker) return;
        }
      }
    }
  };

  // Return the results of applying the iterator to each element.
  // Delegates to **ECMAScript 5**'s native `map` if available.
  _.map = _.collect = function(obj, iterator, context) {
    var results = [];
    if (obj == null) return results;
    if (nativeMap && obj.map === nativeMap) return obj.map(iterator, context);
    each(obj, function(value, index, list) {
      results[results.length] = iterator.call(context, value, index, list);
    });
    return results;
  };

  var reduceError = 'Reduce of empty array with no initial value';

  // **Reduce** builds up a single result from a list of values, aka `inject`,
  // or `foldl`. Delegates to **ECMAScript 5**'s native `reduce` if available.
  _.reduce = _.foldl = _.inject = function(obj, iterator, memo, context) {
    var initial = arguments.length > 2;
    if (obj == null) obj = [];
    if (nativeReduce && obj.reduce === nativeReduce) {
      if (context) iterator = _.bind(iterator, context);
      return initial ? obj.reduce(iterator, memo) : obj.reduce(iterator);
    }
    each(obj, function(value, index, list) {
      if (!initial) {
        memo = value;
        initial = true;
      } else {
        memo = iterator.call(context, memo, value, index, list);
      }
    });
    if (!initial) throw new TypeError(reduceError);
    return memo;
  };

  // The right-associative version of reduce, also known as `foldr`.
  // Delegates to **ECMAScript 5**'s native `reduceRight` if available.
  _.reduceRight = _.foldr = function(obj, iterator, memo, context) {
    var initial = arguments.length > 2;
    if (obj == null) obj = [];
    if (nativeReduceRight && obj.reduceRight === nativeReduceRight) {
      if (context) iterator = _.bind(iterator, context);
      return initial ? obj.reduceRight(iterator, memo) : obj.reduceRight(iterator);
    }
    var length = obj.length;
    if (length !== +length) {
      var keys = _.keys(obj);
      length = keys.length;
    }
    each(obj, function(value, index, list) {
      index = keys ? keys[--length] : --length;
      if (!initial) {
        memo = obj[index];
        initial = true;
      } else {
        memo = iterator.call(context, memo, obj[index], index, list);
      }
    });
    if (!initial) throw new TypeError(reduceError);
    return memo;
  };

  // Return the first value which passes a truth test. Aliased as `detect`.
  _.find = _.detect = function(obj, iterator, context) {
    var result;
    any(obj, function(value, index, list) {
      if (iterator.call(context, value, index, list)) {
        result = value;
        return true;
      }
    });
    return result;
  };

  // Return all the elements that pass a truth test.
  // Delegates to **ECMAScript 5**'s native `filter` if available.
  // Aliased as `select`.
  _.filter = _.select = function(obj, iterator, context) {
    var results = [];
    if (obj == null) return results;
    if (nativeFilter && obj.filter === nativeFilter) return obj.filter(iterator, context);
    each(obj, function(value, index, list) {
      if (iterator.call(context, value, index, list)) results[results.length] = value;
    });
    return results;
  };

  // Return all the elements for which a truth test fails.
  _.reject = function(obj, iterator, context) {
    return _.filter(obj, function(value, index, list) {
      return !iterator.call(context, value, index, list);
    }, context);
  };

  // Determine whether all of the elements match a truth test.
  // Delegates to **ECMAScript 5**'s native `every` if available.
  // Aliased as `all`.
  _.every = _.all = function(obj, iterator, context) {
    iterator || (iterator = _.identity);
    var result = true;
    if (obj == null) return result;
    if (nativeEvery && obj.every === nativeEvery) return obj.every(iterator, context);
    each(obj, function(value, index, list) {
      if (!(result = result && iterator.call(context, value, index, list))) return breaker;
    });
    return !!result;
  };

  // Determine if at least one element in the object matches a truth test.
  // Delegates to **ECMAScript 5**'s native `some` if available.
  // Aliased as `any`.
  var any = _.some = _.any = function(obj, iterator, context) {
    iterator || (iterator = _.identity);
    var result = false;
    if (obj == null) return result;
    if (nativeSome && obj.some === nativeSome) return obj.some(iterator, context);
    each(obj, function(value, index, list) {
      if (result || (result = iterator.call(context, value, index, list))) return breaker;
    });
    return !!result;
  };

  // Determine if the array or object contains a given value (using `===`).
  // Aliased as `include`.
  _.contains = _.include = function(obj, target) {
    if (obj == null) return false;
    if (nativeIndexOf && obj.indexOf === nativeIndexOf) return obj.indexOf(target) != -1;
    return any(obj, function(value) {
      return value === target;
    });
  };

  // Invoke a method (with arguments) on every item in a collection.
  _.invoke = function(obj, method) {
    var args = slice.call(arguments, 2);
    var isFunc = _.isFunction(method);
    return _.map(obj, function(value) {
      return (isFunc ? method : value[method]).apply(value, args);
    });
  };

  // Convenience version of a common use case of `map`: fetching a property.
  _.pluck = function(obj, key) {
    return _.map(obj, function(value){ return value[key]; });
  };

  // Convenience version of a common use case of `filter`: selecting only objects
  // containing specific `key:value` pairs.
  _.where = function(obj, attrs, first) {
    if (_.isEmpty(attrs)) return first ? null : [];
    return _[first ? 'find' : 'filter'](obj, function(value) {
      for (var key in attrs) {
        if (attrs[key] !== value[key]) return false;
      }
      return true;
    });
  };

  // Convenience version of a common use case of `find`: getting the first object
  // containing specific `key:value` pairs.
  _.findWhere = function(obj, attrs) {
    return _.where(obj, attrs, true);
  };

  // Return the maximum element or (element-based computation).
  // Can't optimize arrays of integers longer than 65,535 elements.
  // See: https://bugs.webkit.org/show_bug.cgi?id=80797
  _.max = function(obj, iterator, context) {
    if (!iterator && _.isArray(obj) && obj[0] === +obj[0] && obj.length < 65535) {
      return Math.max.apply(Math, obj);
    }
    if (!iterator && _.isEmpty(obj)) return -Infinity;
    var result = {computed : -Infinity, value: -Infinity};
    each(obj, function(value, index, list) {
      var computed = iterator ? iterator.call(context, value, index, list) : value;
      computed >= result.computed && (result = {value : value, computed : computed});
    });
    return result.value;
  };

  // Return the minimum element (or element-based computation).
  _.min = function(obj, iterator, context) {
    if (!iterator && _.isArray(obj) && obj[0] === +obj[0] && obj.length < 65535) {
      return Math.min.apply(Math, obj);
    }
    if (!iterator && _.isEmpty(obj)) return Infinity;
    var result = {computed : Infinity, value: Infinity};
    each(obj, function(value, index, list) {
      var computed = iterator ? iterator.call(context, value, index, list) : value;
      computed < result.computed && (result = {value : value, computed : computed});
    });
    return result.value;
  };

  // Shuffle an array.
  _.shuffle = function(obj) {
    var rand;
    var index = 0;
    var shuffled = [];
    each(obj, function(value) {
      rand = _.random(index++);
      shuffled[index - 1] = shuffled[rand];
      shuffled[rand] = value;
    });
    return shuffled;
  };

  // An internal function to generate lookup iterators.
  var lookupIterator = function(value) {
    return _.isFunction(value) ? value : function(obj){ return obj[value]; };
  };

  // Sort the object's values by a criterion produced by an iterator.
  _.sortBy = function(obj, value, context) {
    var iterator = lookupIterator(value);
    return _.pluck(_.map(obj, function(value, index, list) {
      return {
        value : value,
        index : index,
        criteria : iterator.call(context, value, index, list)
      };
    }).sort(function(left, right) {
      var a = left.criteria;
      var b = right.criteria;
      if (a !== b) {
        if (a > b || a === void 0) return 1;
        if (a < b || b === void 0) return -1;
      }
      return left.index < right.index ? -1 : 1;
    }), 'value');
  };

  // An internal function used for aggregate "group by" operations.
  var group = function(obj, value, context, behavior) {
    var result = {};
    var iterator = lookupIterator(value || _.identity);
    each(obj, function(value, index) {
      var key = iterator.call(context, value, index, obj);
      behavior(result, key, value);
    });
    return result;
  };

  // Groups the object's values by a criterion. Pass either a string attribute
  // to group by, or a function that returns the criterion.
  _.groupBy = function(obj, value, context) {
    return group(obj, value, context, function(result, key, value) {
      (_.has(result, key) ? result[key] : (result[key] = [])).push(value);
    });
  };

  // Counts instances of an object that group by a certain criterion. Pass
  // either a string attribute to count by, or a function that returns the
  // criterion.
  _.countBy = function(obj, value, context) {
    return group(obj, value, context, function(result, key) {
      if (!_.has(result, key)) result[key] = 0;
      result[key]++;
    });
  };

  // Use a comparator function to figure out the smallest index at which
  // an object should be inserted so as to maintain order. Uses binary search.
  _.sortedIndex = function(array, obj, iterator, context) {
    iterator = iterator == null ? _.identity : lookupIterator(iterator);
    var value = iterator.call(context, obj);
    var low = 0, high = array.length;
    while (low < high) {
      var mid = (low + high) >>> 1;
      iterator.call(context, array[mid]) < value ? low = mid + 1 : high = mid;
    }
    return low;
  };

  // Safely convert anything iterable into a real, live array.
  _.toArray = function(obj) {
    if (!obj) return [];
    if (_.isArray(obj)) return slice.call(obj);
    if (obj.length === +obj.length) return _.map(obj, _.identity);
    return _.values(obj);
  };

  // Return the number of elements in an object.
  _.size = function(obj) {
    if (obj == null) return 0;
    return (obj.length === +obj.length) ? obj.length : _.keys(obj).length;
  };

  // Array Functions
  // ---------------

  // Get the first element of an array. Passing **n** will return the first N
  // values in the array. Aliased as `head` and `take`. The **guard** check
  // allows it to work with `_.map`.
  _.first = _.head = _.take = function(array, n, guard) {
    if (array == null) return void 0;
    return (n != null) && !guard ? slice.call(array, 0, n) : array[0];
  };

  // Returns everything but the last entry of the array. Especially useful on
  // the arguments object. Passing **n** will return all the values in
  // the array, excluding the last N. The **guard** check allows it to work with
  // `_.map`.
  _.initial = function(array, n, guard) {
    return slice.call(array, 0, array.length - ((n == null) || guard ? 1 : n));
  };

  // Get the last element of an array. Passing **n** will return the last N
  // values in the array. The **guard** check allows it to work with `_.map`.
  _.last = function(array, n, guard) {
    if (array == null) return void 0;
    if ((n != null) && !guard) {
      return slice.call(array, Math.max(array.length - n, 0));
    } else {
      return array[array.length - 1];
    }
  };

  // Returns everything but the first entry of the array. Aliased as `tail` and `drop`.
  // Especially useful on the arguments object. Passing an **n** will return
  // the rest N values in the array. The **guard**
  // check allows it to work with `_.map`.
  _.rest = _.tail = _.drop = function(array, n, guard) {
    return slice.call(array, (n == null) || guard ? 1 : n);
  };

  // Trim out all falsy values from an array.
  _.compact = function(array) {
    return _.filter(array, _.identity);
  };

  // Internal implementation of a recursive `flatten` function.
  var flatten = function(input, shallow, output) {
    each(input, function(value) {
      if (_.isArray(value)) {
        shallow ? push.apply(output, value) : flatten(value, shallow, output);
      } else {
        output.push(value);
      }
    });
    return output;
  };

  // Return a completely flattened version of an array.
  _.flatten = function(array, shallow) {
    return flatten(array, shallow, []);
  };

  // Return a version of the array that does not contain the specified value(s).
  _.without = function(array) {
    return _.difference(array, slice.call(arguments, 1));
  };

  // Produce a duplicate-free version of the array. If the array has already
  // been sorted, you have the option of using a faster algorithm.
  // Aliased as `unique`.
  _.uniq = _.unique = function(array, isSorted, iterator, context) {
    if (_.isFunction(isSorted)) {
      context = iterator;
      iterator = isSorted;
      isSorted = false;
    }
    var initial = iterator ? _.map(array, iterator, context) : array;
    var results = [];
    var seen = [];
    each(initial, function(value, index) {
      if (isSorted ? (!index || seen[seen.length - 1] !== value) : !_.contains(seen, value)) {
        seen.push(value);
        results.push(array[index]);
      }
    });
    return results;
  };

  // Produce an array that contains the union: each distinct element from all of
  // the passed-in arrays.
  _.union = function() {
    return _.uniq(concat.apply(ArrayProto, arguments));
  };

  // Produce an array that contains every item shared between all the
  // passed-in arrays.
  _.intersection = function(array) {
    var rest = slice.call(arguments, 1);
    return _.filter(_.uniq(array), function(item) {
      return _.every(rest, function(other) {
        return _.indexOf(other, item) >= 0;
      });
    });
  };

  // Take the difference between one array and a number of other arrays.
  // Only the elements present in just the first array will remain.
  _.difference = function(array) {
    var rest = concat.apply(ArrayProto, slice.call(arguments, 1));
    return _.filter(array, function(value){ return !_.contains(rest, value); });
  };

  // Zip together multiple lists into a single array -- elements that share
  // an index go together.
  _.zip = function() {
    var args = slice.call(arguments);
    var length = _.max(_.pluck(args, 'length'));
    var results = new Array(length);
    for (var i = 0; i < length; i++) {
      results[i] = _.pluck(args, "" + i);
    }
    return results;
  };

  // Converts lists into objects. Pass either a single array of `[key, value]`
  // pairs, or two parallel arrays of the same length -- one of keys, and one of
  // the corresponding values.
  _.object = function(list, values) {
    if (list == null) return {};
    var result = {};
    for (var i = 0, l = list.length; i < l; i++) {
      if (values) {
        result[list[i]] = values[i];
      } else {
        result[list[i][0]] = list[i][1];
      }
    }
    return result;
  };

  // If the browser doesn't supply us with indexOf (I'm looking at you, **MSIE**),
  // we need this function. Return the position of the first occurrence of an
  // item in an array, or -1 if the item is not included in the array.
  // Delegates to **ECMAScript 5**'s native `indexOf` if available.
  // If the array is large and already in sort order, pass `true`
  // for **isSorted** to use binary search.
  _.indexOf = function(array, item, isSorted) {
    if (array == null) return -1;
    var i = 0, l = array.length;
    if (isSorted) {
      if (typeof isSorted == 'number') {
        i = (isSorted < 0 ? Math.max(0, l + isSorted) : isSorted);
      } else {
        i = _.sortedIndex(array, item);
        return array[i] === item ? i : -1;
      }
    }
    if (nativeIndexOf && array.indexOf === nativeIndexOf) return array.indexOf(item, isSorted);
    for (; i < l; i++) if (array[i] === item) return i;
    return -1;
  };

  // Delegates to **ECMAScript 5**'s native `lastIndexOf` if available.
  _.lastIndexOf = function(array, item, from) {
    if (array == null) return -1;
    var hasIndex = from != null;
    if (nativeLastIndexOf && array.lastIndexOf === nativeLastIndexOf) {
      return hasIndex ? array.lastIndexOf(item, from) : array.lastIndexOf(item);
    }
    var i = (hasIndex ? from : array.length);
    while (i--) if (array[i] === item) return i;
    return -1;
  };

  // Generate an integer Array containing an arithmetic progression. A port of
  // the native Python `range()` function. See
  // [the Python documentation](http://docs.python.org/library/functions.html#range).
  _.range = function(start, stop, step) {
    if (arguments.length <= 1) {
      stop = start || 0;
      start = 0;
    }
    step = arguments[2] || 1;

    var len = Math.max(Math.ceil((stop - start) / step), 0);
    var idx = 0;
    var range = new Array(len);

    while(idx < len) {
      range[idx++] = start;
      start += step;
    }

    return range;
  };

  // Function (ahem) Functions
  // ------------------

  // Create a function bound to a given object (assigning `this`, and arguments,
  // optionally). Delegates to **ECMAScript 5**'s native `Function.bind` if
  // available.
  _.bind = function(func, context) {
    if (func.bind === nativeBind && nativeBind) return nativeBind.apply(func, slice.call(arguments, 1));
    var args = slice.call(arguments, 2);
    return function() {
      return func.apply(context, args.concat(slice.call(arguments)));
    };
  };

  // Partially apply a function by creating a version that has had some of its
  // arguments pre-filled, without changing its dynamic `this` context.
  _.partial = function(func) {
    var args = slice.call(arguments, 1);
    return function() {
      return func.apply(this, args.concat(slice.call(arguments)));
    };
  };

  // Bind all of an object's methods to that object. Useful for ensuring that
  // all callbacks defined on an object belong to it.
  _.bindAll = function(obj) {
    var funcs = slice.call(arguments, 1);
    if (funcs.length === 0) funcs = _.functions(obj);
    each(funcs, function(f) { obj[f] = _.bind(obj[f], obj); });
    return obj;
  };

  // Memoize an expensive function by storing its results.
  _.memoize = function(func, hasher) {
    var memo = {};
    hasher || (hasher = _.identity);
    return function() {
      var key = hasher.apply(this, arguments);
      return _.has(memo, key) ? memo[key] : (memo[key] = func.apply(this, arguments));
    };
  };

  // Delays a function for the given number of milliseconds, and then calls
  // it with the arguments supplied.
  _.delay = function(func, wait) {
    var args = slice.call(arguments, 2);
    return setTimeout(function(){ return func.apply(null, args); }, wait);
  };

  // Defers a function, scheduling it to run after the current call stack has
  // cleared.
  _.defer = function(func) {
    return _.delay.apply(_, [func, 1].concat(slice.call(arguments, 1)));
  };

  // Returns a function, that, when invoked, will only be triggered at most once
  // during a given window of time.
  _.throttle = function(func, wait) {
    var context, args, timeout, result;
    var previous = 0;
    var later = function() {
      previous = new Date;
      timeout = null;
      result = func.apply(context, args);
    };
    return function() {
      var now = new Date;
      var remaining = wait - (now - previous);
      context = this;
      args = arguments;
      if (remaining <= 0) {
        clearTimeout(timeout);
        timeout = null;
        previous = now;
        result = func.apply(context, args);
      } else if (!timeout) {
        timeout = setTimeout(later, remaining);
      }
      return result;
    };
  };

  // Returns a function, that, as long as it continues to be invoked, will not
  // be triggered. The function will be called after it stops being called for
  // N milliseconds. If `immediate` is passed, trigger the function on the
  // leading edge, instead of the trailing.
  _.debounce = function(func, wait, immediate) {
    var timeout, result;
    return function() {
      var context = this, args = arguments;
      var later = function() {
        timeout = null;
        if (!immediate) result = func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) result = func.apply(context, args);
      return result;
    };
  };

  // Returns a function that will be executed at most one time, no matter how
  // often you call it. Useful for lazy initialization.
  _.once = function(func) {
    var ran = false, memo;
    return function() {
      if (ran) return memo;
      ran = true;
      memo = func.apply(this, arguments);
      func = null;
      return memo;
    };
  };

  // Returns the first function passed as an argument to the second,
  // allowing you to adjust arguments, run code before and after, and
  // conditionally execute the original function.
  _.wrap = function(func, wrapper) {
    return function() {
      var args = [func];
      push.apply(args, arguments);
      return wrapper.apply(this, args);
    };
  };

  // Returns a function that is the composition of a list of functions, each
  // consuming the return value of the function that follows.
  _.compose = function() {
    var funcs = arguments;
    return function() {
      var args = arguments;
      for (var i = funcs.length - 1; i >= 0; i--) {
        args = [funcs[i].apply(this, args)];
      }
      return args[0];
    };
  };

  // Returns a function that will only be executed after being called N times.
  _.after = function(times, func) {
    if (times <= 0) return func();
    return function() {
      if (--times < 1) {
        return func.apply(this, arguments);
      }
    };
  };

  // Object Functions
  // ----------------

  // Retrieve the names of an object's properties.
  // Delegates to **ECMAScript 5**'s native `Object.keys`
  _.keys = nativeKeys || function(obj) {
    if (obj !== Object(obj)) throw new TypeError('Invalid object');
    var keys = [];
    for (var key in obj) if (_.has(obj, key)) keys[keys.length] = key;
    return keys;
  };

  // Retrieve the values of an object's properties.
  _.values = function(obj) {
    var values = [];
    for (var key in obj) if (_.has(obj, key)) values.push(obj[key]);
    return values;
  };

  // Convert an object into a list of `[key, value]` pairs.
  _.pairs = function(obj) {
    var pairs = [];
    for (var key in obj) if (_.has(obj, key)) pairs.push([key, obj[key]]);
    return pairs;
  };

  // Invert the keys and values of an object. The values must be serializable.
  _.invert = function(obj) {
    var result = {};
    for (var key in obj) if (_.has(obj, key)) result[obj[key]] = key;
    return result;
  };

  // Return a sorted list of the function names available on the object.
  // Aliased as `methods`
  _.functions = _.methods = function(obj) {
    var names = [];
    for (var key in obj) {
      if (_.isFunction(obj[key])) names.push(key);
    }
    return names.sort();
  };

  // Extend a given object with all the properties in passed-in object(s).
  _.extend = function(obj) {
    each(slice.call(arguments, 1), function(source) {
      if (source) {
        for (var prop in source) {
          obj[prop] = source[prop];
        }
      }
    });
    return obj;
  };

  // Return a copy of the object only containing the whitelisted properties.
  _.pick = function(obj) {
    var copy = {};
    var keys = concat.apply(ArrayProto, slice.call(arguments, 1));
    each(keys, function(key) {
      if (key in obj) copy[key] = obj[key];
    });
    return copy;
  };

   // Return a copy of the object without the blacklisted properties.
  _.omit = function(obj) {
    var copy = {};
    var keys = concat.apply(ArrayProto, slice.call(arguments, 1));
    for (var key in obj) {
      if (!_.contains(keys, key)) copy[key] = obj[key];
    }
    return copy;
  };

  // Fill in a given object with default properties.
  _.defaults = function(obj) {
    each(slice.call(arguments, 1), function(source) {
      if (source) {
        for (var prop in source) {
          if (obj[prop] == null) obj[prop] = source[prop];
        }
      }
    });
    return obj;
  };

  // Create a (shallow-cloned) duplicate of an object.
  _.clone = function(obj) {
    if (!_.isObject(obj)) return obj;
    return _.isArray(obj) ? obj.slice() : _.extend({}, obj);
  };

  // Invokes interceptor with the obj, and then returns obj.
  // The primary purpose of this method is to "tap into" a method chain, in
  // order to perform operations on intermediate results within the chain.
  _.tap = function(obj, interceptor) {
    interceptor(obj);
    return obj;
  };

  // Internal recursive comparison function for `isEqual`.
  var eq = function(a, b, aStack, bStack) {
    // Identical objects are equal. `0 === -0`, but they aren't identical.
    // See the Harmony `egal` proposal: http://wiki.ecmascript.org/doku.php?id=harmony:egal.
    if (a === b) return a !== 0 || 1 / a == 1 / b;
    // A strict comparison is necessary because `null == undefined`.
    if (a == null || b == null) return a === b;
    // Unwrap any wrapped objects.
    if (a instanceof _) a = a._wrapped;
    if (b instanceof _) b = b._wrapped;
    // Compare `[[Class]]` names.
    var className = toString.call(a);
    if (className != toString.call(b)) return false;
    switch (className) {
      // Strings, numbers, dates, and booleans are compared by value.
      case '[object String]':
        // Primitives and their corresponding object wrappers are equivalent; thus, `"5"` is
        // equivalent to `new String("5")`.
        return a == String(b);
      case '[object Number]':
        // `NaN`s are equivalent, but non-reflexive. An `egal` comparison is performed for
        // other numeric values.
        return a != +a ? b != +b : (a == 0 ? 1 / a == 1 / b : a == +b);
      case '[object Date]':
      case '[object Boolean]':
        // Coerce dates and booleans to numeric primitive values. Dates are compared by their
        // millisecond representations. Note that invalid dates with millisecond representations
        // of `NaN` are not equivalent.
        return +a == +b;
      // RegExps are compared by their source patterns and flags.
      case '[object RegExp]':
        return a.source == b.source &&
               a.global == b.global &&
               a.multiline == b.multiline &&
               a.ignoreCase == b.ignoreCase;
    }
    if (typeof a != 'object' || typeof b != 'object') return false;
    // Assume equality for cyclic structures. The algorithm for detecting cyclic
    // structures is adapted from ES 5.1 section 15.12.3, abstract operation `JO`.
    var length = aStack.length;
    while (length--) {
      // Linear search. Performance is inversely proportional to the number of
      // unique nested structures.
      if (aStack[length] == a) return bStack[length] == b;
    }
    // Add the first object to the stack of traversed objects.
    aStack.push(a);
    bStack.push(b);
    var size = 0, result = true;
    // Recursively compare objects and arrays.
    if (className == '[object Array]') {
      // Compare array lengths to determine if a deep comparison is necessary.
      size = a.length;
      result = size == b.length;
      if (result) {
        // Deep compare the contents, ignoring non-numeric properties.
        while (size--) {
          if (!(result = eq(a[size], b[size], aStack, bStack))) break;
        }
      }
    } else {
      // Objects with different constructors are not equivalent, but `Object`s
      // from different frames are.
      var aCtor = a.constructor, bCtor = b.constructor;
      if (aCtor !== bCtor && !(_.isFunction(aCtor) && (aCtor instanceof aCtor) &&
                               _.isFunction(bCtor) && (bCtor instanceof bCtor))) {
        return false;
      }
      // Deep compare objects.
      for (var key in a) {
        if (_.has(a, key)) {
          // Count the expected number of properties.
          size++;
          // Deep compare each member.
          if (!(result = _.has(b, key) && eq(a[key], b[key], aStack, bStack))) break;
        }
      }
      // Ensure that both objects contain the same number of properties.
      if (result) {
        for (key in b) {
          if (_.has(b, key) && !(size--)) break;
        }
        result = !size;
      }
    }
    // Remove the first object from the stack of traversed objects.
    aStack.pop();
    bStack.pop();
    return result;
  };

  // Perform a deep comparison to check if two objects are equal.
  _.isEqual = function(a, b) {
    return eq(a, b, [], []);
  };

  // Is a given array, string, or object empty?
  // An "empty" object has no enumerable own-properties.
  _.isEmpty = function(obj) {
    if (obj == null) return true;
    if (_.isArray(obj) || _.isString(obj)) return obj.length === 0;
    for (var key in obj) if (_.has(obj, key)) return false;
    return true;
  };

  // Is a given value a DOM element?
  _.isElement = function(obj) {
    return !!(obj && obj.nodeType === 1);
  };

  // Is a given value an array?
  // Delegates to ECMA5's native Array.isArray
  _.isArray = nativeIsArray || function(obj) {
    return toString.call(obj) == '[object Array]';
  };

  // Is a given variable an object?
  _.isObject = function(obj) {
    return obj === Object(obj);
  };

  // Add some isType methods: isArguments, isFunction, isString, isNumber, isDate, isRegExp.
  each(['Arguments', 'Function', 'String', 'Number', 'Date', 'RegExp'], function(name) {
    _['is' + name] = function(obj) {
      return toString.call(obj) == '[object ' + name + ']';
    };
  });

  // Define a fallback version of the method in browsers (ahem, IE), where
  // there isn't any inspectable "Arguments" type.
  if (!_.isArguments(arguments)) {
    _.isArguments = function(obj) {
      return !!(obj && _.has(obj, 'callee'));
    };
  }

  // Optimize `isFunction` if appropriate.
  if (typeof (/./) !== 'function') {
    _.isFunction = function(obj) {
      return typeof obj === 'function';
    };
  }

  // Is a given object a finite number?
  _.isFinite = function(obj) {
    return isFinite(obj) && !isNaN(parseFloat(obj));
  };

  // Is the given value `NaN`? (NaN is the only number which does not equal itself).
  _.isNaN = function(obj) {
    return _.isNumber(obj) && obj != +obj;
  };

  // Is a given value a boolean?
  _.isBoolean = function(obj) {
    return obj === true || obj === false || toString.call(obj) == '[object Boolean]';
  };

  // Is a given value equal to null?
  _.isNull = function(obj) {
    return obj === null;
  };

  // Is a given variable undefined?
  _.isUndefined = function(obj) {
    return obj === void 0;
  };

  // Shortcut function for checking if an object has a given property directly
  // on itself (in other words, not on a prototype).
  _.has = function(obj, key) {
    return hasOwnProperty.call(obj, key);
  };

  // Utility Functions
  // -----------------

  // Run Underscore.js in *noConflict* mode, returning the `_` variable to its
  // previous owner. Returns a reference to the Underscore object.
  _.noConflict = function() {
    root._ = previousUnderscore;
    return this;
  };

  // Keep the identity function around for default iterators.
  _.identity = function(value) {
    return value;
  };

  // Run a function **n** times.
  _.times = function(n, iterator, context) {
    var accum = Array(n);
    for (var i = 0; i < n; i++) accum[i] = iterator.call(context, i);
    return accum;
  };

  // Return a random integer between min and max (inclusive).
  _.random = function(min, max) {
    if (max == null) {
      max = min;
      min = 0;
    }
    return min + Math.floor(Math.random() * (max - min + 1));
  };

  // List of HTML entities for escaping.
  var entityMap = {
    escape: {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#x27;',
      '/': '&#x2F;'
    }
  };
  entityMap.unescape = _.invert(entityMap.escape);

  // Regexes containing the keys and values listed immediately above.
  var entityRegexes = {
    escape:   new RegExp('[' + _.keys(entityMap.escape).join('') + ']', 'g'),
    unescape: new RegExp('(' + _.keys(entityMap.unescape).join('|') + ')', 'g')
  };

  // Functions for escaping and unescaping strings to/from HTML interpolation.
  _.each(['escape', 'unescape'], function(method) {
    _[method] = function(string) {
      if (string == null) return '';
      return ('' + string).replace(entityRegexes[method], function(match) {
        return entityMap[method][match];
      });
    };
  });

  // If the value of the named property is a function then invoke it;
  // otherwise, return it.
  _.result = function(object, property) {
    if (object == null) return null;
    var value = object[property];
    return _.isFunction(value) ? value.call(object) : value;
  };

  // Add your own custom functions to the Underscore object.
  _.mixin = function(obj) {
    each(_.functions(obj), function(name){
      var func = _[name] = obj[name];
      _.prototype[name] = function() {
        var args = [this._wrapped];
        push.apply(args, arguments);
        return result.call(this, func.apply(_, args));
      };
    });
  };

  // Generate a unique integer id (unique within the entire client session).
  // Useful for temporary DOM ids.
  var idCounter = 0;
  _.uniqueId = function(prefix) {
    var id = ++idCounter + '';
    return prefix ? prefix + id : id;
  };

  // By default, Underscore uses ERB-style template delimiters, change the
  // following template settings to use alternative delimiters.
  _.templateSettings = {
    evaluate    : /<%([\s\S]+?)%>/g,
    interpolate : /<%=([\s\S]+?)%>/g,
    escape      : /<%-([\s\S]+?)%>/g
  };

  // When customizing `templateSettings`, if you don't want to define an
  // interpolation, evaluation or escaping regex, we need one that is
  // guaranteed not to match.
  var noMatch = /(.)^/;

  // Certain characters need to be escaped so that they can be put into a
  // string literal.
  var escapes = {
    "'":      "'",
    '\\':     '\\',
    '\r':     'r',
    '\n':     'n',
    '\t':     't',
    '\u2028': 'u2028',
    '\u2029': 'u2029'
  };

  var escaper = /\\|'|\r|\n|\t|\u2028|\u2029/g;

  // JavaScript micro-templating, similar to John Resig's implementation.
  // Underscore templating handles arbitrary delimiters, preserves whitespace,
  // and correctly escapes quotes within interpolated code.
  _.template = function(text, data, settings) {
    var render;
    settings = _.defaults({}, settings, _.templateSettings);

    // Combine delimiters into one regular expression via alternation.
    var matcher = new RegExp([
      (settings.escape || noMatch).source,
      (settings.interpolate || noMatch).source,
      (settings.evaluate || noMatch).source
    ].join('|') + '|$', 'g');

    // Compile the template source, escaping string literals appropriately.
    var index = 0;
    var source = "__p+='";
    text.replace(matcher, function(match, escape, interpolate, evaluate, offset) {
      source += text.slice(index, offset)
        .replace(escaper, function(match) { return '\\' + escapes[match]; });

      if (escape) {
        source += "'+\n((__t=(" + escape + "))==null?'':_.escape(__t))+\n'";
      }
      if (interpolate) {
        source += "'+\n((__t=(" + interpolate + "))==null?'':__t)+\n'";
      }
      if (evaluate) {
        source += "';\n" + evaluate + "\n__p+='";
      }
      index = offset + match.length;
      return match;
    });
    source += "';\n";

    // If a variable is not specified, place data values in local scope.
    if (!settings.variable) source = 'with(obj||{}){\n' + source + '}\n';

    source = "var __t,__p='',__j=Array.prototype.join," +
      "print=function(){__p+=__j.call(arguments,'');};\n" +
      source + "return __p;\n";

    try {
      render = new Function(settings.variable || 'obj', '_', source);
    } catch (e) {
      e.source = source;
      throw e;
    }

    if (data) return render(data, _);
    var template = function(data) {
      return render.call(this, data, _);
    };

    // Provide the compiled function source as a convenience for precompilation.
    template.source = 'function(' + (settings.variable || 'obj') + '){\n' + source + '}';

    return template;
  };

  // Add a "chain" function, which will delegate to the wrapper.
  _.chain = function(obj) {
    return _(obj).chain();
  };

  // OOP
  // ---------------
  // If Underscore is called as a function, it returns a wrapped object that
  // can be used OO-style. This wrapper holds altered versions of all the
  // underscore functions. Wrapped objects may be chained.

  // Helper function to continue chaining intermediate results.
  var result = function(obj) {
    return this._chain ? _(obj).chain() : obj;
  };

  // Add all of the Underscore functions to the wrapper object.
  _.mixin(_);

  // Add all mutator Array functions to the wrapper.
  each(['pop', 'push', 'reverse', 'shift', 'sort', 'splice', 'unshift'], function(name) {
    var method = ArrayProto[name];
    _.prototype[name] = function() {
      var obj = this._wrapped;
      method.apply(obj, arguments);
      if ((name == 'shift' || name == 'splice') && obj.length === 0) delete obj[0];
      return result.call(this, obj);
    };
  });

  // Add all accessor Array functions to the wrapper.
  each(['concat', 'join', 'slice'], function(name) {
    var method = ArrayProto[name];
    _.prototype[name] = function() {
      return result.call(this, method.apply(this._wrapped, arguments));
    };
  });

  _.extend(_.prototype, {

    // Start chaining a wrapped Underscore object.
    chain: function() {
      this._chain = true;
      return this;
    },

    // Extracts the result from a wrapped and chained object.
    value: function() {
      return this._wrapped;
    }

  });

}).call(this);

/* End of File sidecar/lib/backbone/underscore.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

/**
 * Namespace for Sugar Objects
 */
if (typeof(SUGAR) == "undefined") {
    SUGAR = {

        /**
         * Creates a namespace if it doesn't exist and then returns it.
         *
         * Note: this implementation only creates a top-level namespace. Extend this function if
         * multi-level namespaces are needed.
         * @param ns
         */
        namespace: function(ns) {
            SUGAR[ns] = SUGAR[ns] || {};

            return ((typeof SUGAR[ns] === "object") && (SUGAR[ns] !== null)) ? SUGAR[ns] : false;
        },

        /**
         * Add properties of an object to target object.
         * @param target
         * @param obj
         */
        append: function(target, obj) {
            for (var prop in obj) {
                if (obj[prop] !== void 0) target[prop] = obj[prop];
            }

            return target;
        }
    };
}

// Namespaces
SUGAR.namespace("themes");
SUGAR.namespace("tour");

/**
 * Namespace for Homepage
 */
 SUGAR.namespace("sugarHome");

/**
 * Namespace for Subpanel Utils
 */
SUGAR.namespace("subpanelUtils");

/**
 * AJAX status class
 */
SUGAR.namespace("ajaxStatusClass");

/**
 * Tab selector utils
 */
SUGAR.namespace("tabChooser");

/**
 * General namespace for Sugar utils
 */
SUGAR.namespace("utils");
SUGAR.namespace("savedViews");

/**
 * Dashlet utils
 */
SUGAR.namespace("dashlets");
SUGAR.namespace("unifiedSearchAdvanced");

SUGAR.namespace("searchForm");
SUGAR.namespace("language");
SUGAR.namespace("Studio");
SUGAR.namespace("contextMenu");
SUGAR.namespace("config");

var nameIndex = 0;
var typeIndex = 1;
var requiredIndex = 2;
var msgIndex = 3;
var jstypeIndex = 5;
var minIndex = 10;
var maxIndex = 11;
var altMsgIndex = 15;
var compareToIndex = 7;
var arrIndex = 12;
var operatorIndex = 13;
var callbackIndex = 16;
var allowblank = 8;
var validate = new Array();
var maxHours = 24;
var requiredTxt = 'Missing Required Field:';
var invalidTxt = 'Invalid Value:';
var secondsSinceLoad = 0;
var alertsTimeoutId;
var inputsWithErrors = new Array();
var tabsWithErrors = new Array();
var lastSubmitTime = 0;
var alertList = new Array();
var oldStartsWith = '';

/**
 * @deprecated
 *
 * As of Sugar version 6.2.3 (MSIE Version 9) this function is deprecated.  The preferred method is to use the
 * user agent check supplied by YUI to check for IE:
 *
 * for checking if a browser is IE in general :  if(YAHOO.env.ua.ie) {...}
 *
 * or for checking specific versions:  if (YAHOO.env.ua.ie >= 5.5 && YAHOO.env.ua.ie < 9) {...}
 *
 */
function isSupportedIE() {
    var userAgent = navigator.userAgent.toLowerCase();

    // IE Check supports ActiveX controls
    if ($.browser.msie) {
        var version = $.browser.version;
        if (version >= 5.5 && version < 15) {
            return true;
        } else {
            return false;
        }
    }
}

SUGAR.isUnsupportedIE = function () {
    var userAgent = navigator.userAgent.toLowerCase();
    // IE Check supports ActiveX controls
    if ($.browser.msie) {
        var version = $.browser.version;
        return version < 15;
    }
    return false;
};

function checkMinSupported(c, s) {
    var current = c.split(".");
    var supported = s.split(".");
    for (var i in supported) {
        if (current[i] && parseInt(current[i]) > parseInt(supported[i])) return true;
        else if (current[i] && parseInt(current[i]) < parseInt(supported[i])) return false;
    }
    return true;
}

function checkMaxSupported(c, s) {
    var current = c.split(".");
    var supported = s.split(".");
    for (var i in supported) {
        if (current[i] && parseInt(current[i]) > parseInt(supported[i])) return false;
        else if (current[i] && parseInt(current[i]) < parseInt(supported[i])) return true;
    }
    return true;
}

SUGAR.isSupportedBrowser = function(){
    var supportedBrowsers = {
        msie : {min:9, max:11}, // IE 9, 10, 11
        safari : {min:537}, // Safari 7.1
        mozilla : {min:37}, // Firefox 37
        chrome : {min:537.36} // Chrome 42
    };
    var current = String($.browser.version);
        var supported;
        if ($.browser.msie){ // Internet Explorer
            supported = supportedBrowsers['msie'];
        }
        else if ($.browser.mozilla) { // Firefox
            supported = supportedBrowsers['mozilla'];
        }
        else {
            $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
            if($.browser.chrome){ // Chrome
                supported = supportedBrowsers['chrome'];
            }
            else if($.browser.safari){ // Safari
                supported = supportedBrowsers['safari'];
            }
        }
        if (current && supported)
            return checkMinSupported(current, String(supported.min)) && (!supported.max || checkMaxSupported(current, String(supported.max)));
        else
            return false;
}

SUGAR.isIECompatibilityMode = function(){
    var agentStr = navigator.userAgent;
    var mode = false;
    if (agentStr.indexOf("MSIE 7.0") > -1 &&
        (agentStr.indexOf("Trident/5.0") > -1 || // IE9 Compatibility View
         agentStr.indexOf("Trident/4.0") > -1    // IE8 Compatibility View
        )
    )
    {
        mode = true;
    }
    return mode;
}

SUGAR.tour = function() {
    var tourModal;
    var screenShotModal;
    return {
        init: function(params) {
            var modals = params.modals;

            tourModal = $('<div id="'+params.id+'" class="modal '+params.className+' tour slides"></div>').modal({backdrop: false}).draggable({handle: ".modal-header"});
            tourModal.modal("hide");

            screenShotModal = $('<div id="'+params.id+'_screenshot" class="modal '+params.className+' tour screenshot"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>Screen Shot</h3></div><div class="modal-body"></div></div>').modal();
            screenShotModal.modal("hide");

            var tourIdSel = "#"+params.id;
            var screenShotIdSel = "#"+params.id+"_screenshot";

            $.ajax({
                url: params.modalUrl,
                success: function(data){
                    $(tourIdSel).html(data);
                    tourModal.modal("show");
                    $(tourIdSel+'Start a.btn.btn-primary').on("click",function(e){
                        $(tourIdSel+'Start').css("display","none");
                        $(tourIdSel+'End').css("display","block");
                        tourModal.modal("hide");
                        modalArray[0].modal('show');
                        $(modals[0].target).popoverext('show');
                        centerModal();
                    });
                    $(tourIdSel+'Start a.btn').not('.btn-primary').on("click",function(e){
                        $(tourIdSel+'Start').css("display","none");
                        $(tourIdSel+'End').css("display","block");
                        centerModal();
                    });
                    $(tourIdSel+'End a.btn.btn-primary').on("click",function(e){
                        tourModal.modal("hide");
                        $(tourIdSel+'Start').css("display","block");
                        $(tourIdSel+'End').css("display","none");
                        centerModal();
                        SUGAR.tour.saveUserPref(params.prefUrl);
                        params.onTourFinish();
                    });
                    $(tourIdSel+'End a.btn').not('.btn-primary').on("click",function(e){
                        tourModal.modal("hide");
                        var lastModal = modals.length-1;
                        modalArray[lastModal].modal('show');
                        $(modals[lastModal].target).popoverext('show');
                        centerModal();
                    });

                    $('div.modal.'+params.className+'.tour.slides a.close').live("click",function(e){
                        closeTour();
                    });

                    centerModal();

                    $('<div style="position: absolute;" id="tourArrow">arrow</div>');
                    var modalArray = new Array();

                    for(var i=0; i<modals.length; i++) {
                        var modalId =  (modals[i].target == undefined)? "tour_"+i+"_modal" : modals[i].target.replace("#","")+"_modal";
                        modalArray[i] = $('<div id="'+modalId+'" class="modal '+params.className+' tour slides"></div>').modal({backdrop: false}).draggable({handle: ".modal-header"});
//                        modalArray[i].modal('show');
                        var modalContent = "<div class=\"modal-header\"><a class=\"close\" data-dismiss=\"modal\">×</a><h3>"+modals[i].title+"</h3></div>";

                        modalContent += "<div class=\"modal-body\">"+modals[i].content+"</div>" ;

                        modalContent += footerTemplate(i,modals);
                        $('#'+modalId).html(modalContent);
                        modalArray[i].modal("hide");


                        $(modals[i].target).ready(function(){

                            var direction,bounce;
                            if (modals[i].placement == "top right") {
                                bounce = "up right";
                                direction = "down right";
                            } else if (modals[i].placement == "top left") {
                                bounce = "up left";
                                direction = "down left";
                            } else if(modals[i].placement == "top") {
                                bounce = "up";
                                direction = "down";
                            } else if (modals[i].placement == "bottom right") {
                                bounce = "down right";
                                direction = "up right";
                            } else if (modals[i].placement == "bottom left") {
                                bounce = "down left";
                                direction = "up left";
                            } else {
                                bounce = "down";
                                direction = "right";
                            }

                            screenshot(i);
                            $(modals[i].target).popoverext({
                                title: "",
                                content: "arrow",
                                footer: "",
                                placement: modals[i].placement,
                                id: true,
                                fixed: true,
                                trigger: 'manual',
                                template: '<div class="popover arrow"><div class="pointer ' +direction+'"></div></div>',
                                onShow:  function(){
                                    $('.pointer').css('top','0px');

                                    $(".popover .pointer")
                                        .effect("custombounce", { times:1000, direction: bounce, distance: 50, gravity: false }, 2000,
                                        function(){

//                                    $('.pointer').attr('style','');

                                        }
                                    );
                                },
                                leftOffset: modals[i].leftOffset ? modals[i].leftOffset : 0,
                                topOffset: modals[i].topOffset ? modals[i].topOffset : 0,
                                hideOnBlur: true

                            });
                        });
                        //empty popover div and insert arrow
                        $(modals[i].target+"Popover").empty().html("arrow");

                    }

                    $(window).resize(function() {
                        centerModal();
                    });

                    function screenshot(i){
                        var thumb = i+1;
                        if(modals[i].screenShotUrl != undefined) {
                            $('#thumbnail_'+thumb).live("click", function(){
                                $(screenShotIdSel+ " .modal-header h3").html(modals[i].title);
                                $(screenShotIdSel+ " .modal-body").html("<img src='"+modals[i].screenShotUrl+"' width='600'>");
                                screenShotModal.modal("show");
                                centerModal();
                            });
                        }

                    }

                    function centerModal() {
                        $(".tour").each(function(){
                            $(this).css("left",$(window).width()/2 - $(this).width()/2);
                            $(this).css("margin-top",-$(this).height()/2);
                        });

                    }

                    function closeTour() {
                        tourModal.modal("hide");
                        $(tourIdSel+'Start').css("display","block");
                        $(tourIdSel+'End').css("display","none");
                        centerModal();
                        SUGAR.tour.saveUserPref(params.prefUrl);
                        $('.popover').blur();
                        params.onTourFinish();
                    }

                    function nextModal (i) {


                        if(modals.length - 1 != i) {
                            $(modals[i].target).popoverext('hide');
                            $(modals[i+1].target).popoverext('show');
                            modalArray[i].modal('hide');
                            modalArray[i+1].modal('show');
                            centerModal();

                        } else {
                            $(modals[i].target).popoverext('hide');
                            modalArray[i].modal('hide');
                            tourModal.modal("show");
                            centerModal();
                        }

                    }

                    function prevModal (i){

                        $(modals[i].target).popoverext('hide');
                        $(modals[i-1].target).popoverext('show');
                        modalArray[i].modal('hide');
                        modalArray[i-1].modal('show');
                    }


                    function skipTour (i) {
                        $(modals[i].target).popoverext('hide');
                        modalArray[i].modal('hide');
                        $(tourIdSel+'End').css("display","block");
                        $(tourIdSel+'Start').css("display","none");
                        tourModal.modal("show");
                        centerModal();
                    }

                    function footerTemplate (i,modals) {
                        var content = $('<div></div>')
                        var footer = $("<div class=\"modal-footer\"></div>");

                        var skip = $("<a href=\"#\" class=\"btn btn-invisible\" id=\"skipTour\">"+SUGAR.language.get('app_strings', 'LBL_TOUR_SKIP')+"</a>");
                        var next = $('<a class="btn btn-primary" id="nextModal'+i+'" href="#">'+SUGAR.language.get('app_strings', 'LBL_TOUR_NEXT')+' <i class="icon-play icon-xsm"></i></a>');
                        content.append(footer);
                        footer.append(skip).append(next);

                        var back = $('<a class="btn" href="#" id="prevModal'+i+'">'+SUGAR.language.get('app_strings', 'LBL_TOUR_BACK')+'</a>');


                        $('#nextModal'+i).live("click", function(){
                            nextModal(i);
                        });

                        $('#prevModal'+i).live("click", function(){
                            prevModal(i);
                        });

                        $('#skipTour').live("click", function(){
                            skipTour(i);
                        });



                        if(i != 0) {
                            footer.append(back);
                        }

                        return content.html();
                    }

                }
            });
        },
        saveUserPref: function(url) {
            $.ajax({
                type: "GET",
                url: url
            });
        }
    };
}();

SUGAR.isIE = isSupportedIE();
var isSafari = (navigator.userAgent.toLowerCase().indexOf('safari')!=-1);

// escapes regular expression characters
RegExp.escape = function(text) { // http://simon.incutio.com/archive/2006/01/20/escape
  if (!arguments.callee.sRE) {
    var specials = ['/', '.', '*', '+', '?', '|','(', ')', '[', ']', '{', '}', '\\'];
    arguments.callee.sRE = new RegExp('(\\' + specials.join('|\\') + ')', 'g');
  }
  return text.replace(arguments.callee.sRE, '\\$1');
}

function addAlert(type, name,subtitle, description,time, redirect) {
	var addIndex = alertList.length;
	alertList[addIndex]= new Array();
	alertList[addIndex]['name'] = name;
	alertList[addIndex]['type'] = type;
	alertList[addIndex]['subtitle'] = subtitle;
	alertList[addIndex]['description'] = replaceHTMLChars(description.replace(/<br>/gi, "\n"));
	alertList[addIndex]['time'] = time;
	alertList[addIndex]['done'] = 0;
	alertList[addIndex]['redirect'] = redirect;
}
function checkAlerts() {
	secondsSinceLoad += 1;
	var mj = 0;
	var alertmsg = '';
	for(mj = 0 ; mj < alertList.length; mj++) {
		if(alertList[mj]['done'] == 0) {
			if(alertList[mj]['time'] < secondsSinceLoad && alertList[mj]['time'] > -1 ) {
				alertmsg = alertList[mj]['type'] + ":" + alertList[mj]['name'] + "\n" +alertList[mj]['subtitle']+ "\n"+ alertList[mj]['description'] + "\n\n";
				alertList[mj]['done'] = 1;
				if(alertList[mj]['redirect'] == '') {
					alert(alertmsg);
				}
				else if(confirm(alertmsg)) {
					window.location = alertList[mj]['redirect'];
				}
			}
		}
	}

    alertsTimeoutId = setTimeout("checkAlerts()", 1000);
}

function toggleDisplay(id) {
	if(this.document.getElementById(id).style.display == 'none') {
		this.document.getElementById(id).style.display = '';
		if(this.document.getElementById(id+"link") != undefined) {
			this.document.getElementById(id+"link").style.display = 'none';
		}
		if(this.document.getElementById(id+"_anchor") != undefined)
			this.document.getElementById(id+"_anchor").innerHTML='[ - ]';
	}
	else {
		this.document.getElementById(id).style.display = 'none';
		if(this.document.getElementById(id+"link") != undefined) {
			this.document.getElementById(id+"link").style.display = '';
		}
		if(this.document.getElementById(id+"_anchor") != undefined)
			this.document.getElementById(id+"_anchor").innerHTML='[+]';
	}
}

function checkAll(form, field, value) {
	for (i = 0; i < form.elements.length; i++) {
		if(form.elements[i].name == field)
			form.elements[i].checked = value;
	}
}

function replaceAll(text, src, rep) {
	offset = text.toLowerCase().indexOf(src.toLowerCase());
	while(offset != -1) {
		text = text.substring(0, offset) + rep + text.substring(offset + src.length ,text.length);
		offset = text.indexOf( src, offset + rep.length + 1);
	}
	return text;
}

function addForm(formname) {
	validate[formname] = new Array();
}

function addToValidate(formname, name, type, required, msg) {
	if(typeof validate[formname] == 'undefined') {
		addForm(formname);
	}
	validate[formname][validate[formname].length] = new Array(name, type,required, msg);
}

// Bug #47961 Callback validator definition
function addToValidateCallback(formname, name, type, required, msg, callback)
{
    addToValidate(formname, name, type, required, msg);
    var iIndex = validate[formname].length -1;
    validate[formname][iIndex][jstypeIndex] = 'callback';
    validate[formname][iIndex][callbackIndex] = callback;
}

function addToValidateRange(formname, name, type,required,  msg,min,max) {
	addToValidate(formname, name, type,required,  msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'range';
	validate[formname][validate[formname].length - 1][minIndex] = min;
	validate[formname][validate[formname].length - 1][maxIndex] = max;
}

function addToValidateIsValidDate(formname, name, type, required, msg) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'date';
}

function addToValidateIsValidTime(formname, name, type, required, msg) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'time';
}

function addToValidateDateBefore(formname, name, type, required, msg, compareTo) {
	addToValidate(formname, name, type,required,  msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'isbefore';
	validate[formname][validate[formname].length - 1][compareToIndex] = compareTo;
}

function addToValidateDateBeforeAllowBlank(formname, name, type, required, msg, compareTo, allowBlank) {
	addToValidate(formname, name, type,required,  msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'isbefore';
	validate[formname][validate[formname].length - 1][compareToIndex] = compareTo;
	validate[formname][validate[formname].length - 1][allowblank] = allowBlank;
}

function addToValidateBinaryDependency(formname, name, type, required, msg, compareTo) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'binarydep';
	validate[formname][validate[formname].length - 1][compareToIndex] = compareTo;
}

function addToValidateComparison(formname, name, type, required, msg, compareTo) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'comparison';
	validate[formname][validate[formname].length - 1][compareToIndex] = compareTo;
}

function addToValidateIsInArray(formname, name, type, required, msg, arr, operator) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'in_array';
	validate[formname][validate[formname].length - 1][arrIndex] = arr;
	validate[formname][validate[formname].length - 1][operatorIndex] = operator;
}

function addToValidateVerified(formname, name, type, required, msg, arr, operator) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'verified';
}

function addToValidateLessThan(formname, name, type, required, msg, max, max_field_msg) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'less';
    validate[formname][validate[formname].length - 1][maxIndex] = max;
    validate[formname][validate[formname].length - 1][altMsgIndex] = max_field_msg;

}
function addToValidateMoreThan(formname, name, type, required, msg, min) {
	addToValidate(formname, name, type, required, msg);
	validate[formname][validate[formname].length - 1][jstypeIndex] = 'more';
    validate[formname][validate[formname].length - 1][minIndex] = min;
}


function removeFromValidate(formname, name) {
	for(i = 0; i < validate[formname].length; i++)
	{
		if(validate[formname][i][nameIndex] == name)
		{
			validate[formname].splice(i--,1); // We subtract 1 from i since the slice removed an element, and we'll skip over the next item we scan
		}
	}
}
function checkValidate(formname, name) {
    if(validate[formname]){
	    for(i = 0; i < validate[formname].length; i++){
	        if(validate[formname][i][nameIndex] == name){
	            return true;
	        }
	    }
	}
    return false;
}
var formsWithFieldLogic=null;
var formWithPrecision =null;
function addToValidateFieldLogic(formId,minFieldId, maxFieldId, defaultFieldId, lenFieldId,type,msg){
	this.formId = document.getElementById(formId);
	this.min=document.getElementById(minFieldId);
	this.max= document.getElementById(maxFieldId);
	this._default= document.getElementById(defaultFieldId);
	this.len = document.getElementById(lenFieldId);
	this.msg = msg;
	this.type= type;
}
//@params: formid- Dom id of the form containing the precision and float fields
//         valudId- Dom id of the field containing a float whose precision is to be checked.
//         precisionId- Dom id of the field containing precision value.
function addToValidatePrecision(formId, valueId, precisionId){
	this.form = document.getElementById(formId);
	this.float = document.getElementById(valueId);
	this.precision = document.getElementById(precisionId);
}

//function checkLength(value, referenceValue){
//	return value
//}

function isValidPrecision(value, precision){
	value = trim(value.toString());
	if(precision == '')
		return true;
	if(value == '')
	    return true;
	//#27021
	if( (precision == "0") ){
		if (value.indexOf(dec_sep)== -1){
			return true;
		}else{
			return false;
		}
	}
	//#27021   end
	if(value.charAt(value.length-precision-1) == num_grp_sep){
		if(value.substr(value.indexOf(dec_sep), 1)==dec_sep){
			return false;
		}
		return 	true;
	}
	var actualPrecision = value.substr(value.indexOf(dec_sep)+1, value.length).length;
	return actualPrecision == precision;
}
function toDecimal(original, precision) {
    precision = (precision == null) ? 2 : precision;
    num = Math.pow(10, precision);
	temp = Math.round(original*num)/num;
	if((temp * 100) % 100 == 0)
		return temp + '.00';
	if((temp * 10) % 10 == 0)
		return temp + '0';
	return temp
}

function isInteger(s) {
	if(typeof num_grp_sep != 'undefined' && typeof dec_sep != 'undefined')
	{
		s = unformatNumberNoParse(s, num_grp_sep, dec_sep).toString();
	}
	return /^[+-]?[0-9]*$/.test(s) ;
}

function isDecimal(s) {
    if (typeof s == "string" && s == "")    // bug# 46530, this is required in order to
        return true;                        // not check empty decimal fields

	if(typeof num_grp_sep != 'undefined' && typeof dec_sep != 'undefined')
	{
		s = unformatNumberNoParse(s, num_grp_sep, dec_sep).toString();
	}
	return  /^[+-]?[0-9]*\.?[0-9]*$/.test(s) ;
}

function isNumeric(s) {
	return isDecimal(s);
}

if (typeof date_reg_positions != "object") var date_reg_positions = {'Y': 1,'m': 2,'d': 3};
if (typeof date_reg_format != "string") var date_reg_format = '([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})';

function isDate(dtStr) {

	if(dtStr.length== 0) {
		return true;
	}

    // Check that we have numbers
	myregexp = new RegExp(date_reg_format)
	if(!myregexp.test(dtStr))
		return false

    m = '';
    d = '';
    y = '';

    var dateParts = dtStr.match(date_reg_format);
    for(key in date_reg_positions) {
        index = date_reg_positions[key];
        if(key == 'm') {
           m = dateParts[index];
        } else if(key == 'd') {
           d = dateParts[index];
        } else {
           y = dateParts[index];
        }
    }

    // Check that date is real
    var dd = new Date(y,m,0);
    // reject negative years
    if (y < 1)
        return false;
    // reject month less than 1 and greater than 12
    if (m > 12 || m < 1)
        return false;
    // reject days less than 1 or days not in month (e.g. February 30th)
    if (d < 1 || d > dd.getDate())
        return false;
    return true;
}

function getDateObject(dtStr) {
	if(dtStr.length== 0) {
		return true;
	}
        if (dtStr instanceof Date) {
            return dtStr;
        }

	myregexp = new RegExp(date_reg_format)

	if(myregexp.exec(dtStr)) var dt = myregexp.exec(dtStr)
	else return false;

	var yr = dt[date_reg_positions['Y']];
	var mh = dt[date_reg_positions['m']];
	var dy = dt[date_reg_positions['d']];
    var dtar = dtStr.split(' ');
    if(typeof(dtar[1])!='undefined' && isTime(dtar[1])) {//if it is a timedate, we should make date1 to have time value
        var t1 = dtar[1].replace(/am/i,' AM');
        var t1 = t1.replace(/pm/i,' PM');
        //bug #37977: where time format 23.00 causes java script error
        t1=t1.replace(/\./, ':');
        date1 = new Date(Date.parse(mh+'/'+dy+ '/'+yr+' '+t1));
    }
    else
    {
        var date1 = new Date();
        date1.setFullYear(yr); // xxxx 4 char year
        date1.setMonth(mh-1); // 0-11 Bug 4048: javascript Date obj months are 0-index
        date1.setDate(dy); // 1-31
    }
	return date1;
}

function isBefore(value1, value2) {
	var d1 = getDateObject(value1);
	var d2 = getDateObject(value2);
    if(typeof(d2)=='boolean') {// if d2 is not set, we should let it pass, the d2 may not need to be set. the empty check should not be done here.
        return true;
    }
	return d2 >= d1;
}

function isValidEmail(emailStr) {

    if(emailStr.length== 0) {
		return true;
	}
	// cn: bug 7128, a period at the end of the string mangles checks. (switched to accept spaces and delimiters)
	var lastChar = emailStr.charAt(emailStr.length - 1);
	if(!lastChar.match(/[^\.]/i)) {
		return false;
	}
	//bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
	//first character of local part of an email address
	//should not be a period i.e. '.'

	var firstLocalChar=emailStr.charAt(0);
	if(firstLocalChar.match(/\./)){
		return false;
	}

	//bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
	//last character of local part of an email address
	//should not be a period i.e. '.'

	var pos=emailStr.lastIndexOf("@");
	var localPart = emailStr.substr(0, pos);
	var lastLocalChar=localPart.charAt(localPart.length - 1);
	if(lastLocalChar.match(/\./)){
		return false;
	}


	var reg = /@.*?;/g;
    var results;
	while ((results = reg.exec(emailStr)) != null) {
			var original = results[0];
			parsedResult = results[0].replace(';', '::;::');
			emailStr = emailStr.replace (original, parsedResult);
	}

	reg = /.@.*?,/g;
	while ((results = reg.exec(emailStr)) != null) {
			var original = results[0];
			//Check if we were using ; as a delimiter. If so, skip the commas
            if(original.indexOf("::;::") == -1) {
                var parsedResult = results[0].replace(',', '::;::');
			    emailStr = emailStr.replace (original, parsedResult);
            }
	}

	// mfh: bug 15010 - more practical implementation of RFC 2822 from http://www.regular-expressions.info/email.html, modifed to accept CAPITAL LETTERS
	//if(!/[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/.test(emailStr))
	//	return false

	//bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
	//allowed special characters ! # $ % & ' * + - / = ?  ^ _ ` . { | } ~ in local part
    var emailArr = emailStr.split(/::;::/);
	for (var i = 0; i < emailArr.length; i++) {
		var emailAddress = emailArr[i];
		if (trim(emailAddress) != '') {
			if(!/^\s*[\w.%+\-&'#!\$\*=\?\^_`\{\}~\/]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}\s*$/i.test(emailAddress) &&
			   !/^.*<[A-Z0-9._%+\-&'#!\$\*=\?\^_`\{\}~]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}>\s*$/i.test(emailAddress)) {

			   return false;
			} // if
		}
	} // for
	return true;
}

function isValidPhone(phoneStr) {
	if(phoneStr.length== 0) {
		return true;
	}
	if(!/^[0-9\-\(\)\s]+$/.test(phoneStr))
		return false
	return true
}
function isFloat(floatStr) {
	if(floatStr.length== 0) {
		return true;
	}
	if(!(typeof(num_grp_sep)=='undefined' || typeof(dec_sep)=='undefined')) {
		floatStr = unformatNumberNoParse(floatStr, num_grp_sep, dec_sep).toString();
    }

	return /^(-)?[0-9\.]+$/.test(floatStr);
}
function isDBName(str) {

	if(str.length== 0) {
		return true;
	}
	// must start with a letter
	if(!/^[a-zA-Z][a-zA-Z\_0-9]*$/.test(str))
		return false
	return true
}
var time_reg_format = "[0-9]{1,2}\:[0-9]{2}";
function isTime(timeStr) {
    var timeRegex = time_reg_format;
    // eliminate the am/pm from the external time_reg_format
	timeRegex = timeRegex.replace(/[ ]*\([^)]*m\)/i, '');
	if(timeStr.length== 0){
		return true;
	}
	//we now support multiple time formats
	myregexp = new RegExp(timeRegex);
	if(!myregexp.test(timeStr)) {
        return false;
    }

	return true;
}

function inRange(value, min, max) {
    if (typeof num_grp_sep != 'undefined' && typeof dec_sep != 'undefined')
       value = unformatNumberNoParse(value, num_grp_sep, dec_sep).toString();
    var result = true;
    if (typeof min == 'number' && value < min)
    {
        result = false;
    }
    if (typeof max == 'number' && value > max)
    {
        result = false;
    }
    return result;
}

function bothExist(item1, item2) {
	if(typeof item1 == 'undefined') { return false; }
	if(typeof item2 == 'undefined') { return false; }
	if((item1 == '' && item2 != '') || (item1 != '' && item2 == '') ) { return false; }
	return true;
}

trim = YAHOO.lang.trim;


function check_form(formname) {
	if (typeof(siw) != 'undefined' && siw
		&& typeof(siw.selectingSomething) != 'undefined' && siw.selectingSomething)
			return false;
	return validate_form(formname, '');
}

function add_error_style(formname, input, txt, flash) {
    var raiseFlag = false;
	if (typeof flash == "undefined")
		flash = true;
	try {
	inputHandle = typeof input == "object" ? input : document.forms[formname][input];
	style = get_current_bgcolor(inputHandle);

	// strip off the colon at the end of the warning strings
	if ( txt.substring(txt.length-1) == ':' )
	    txt = txt.substring(0,txt.length-1)

	// Bug 28249 - To help avoid duplicate messages for an element, strip off extra messages and
	// match on the field name itself
	requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
    invalidTxt = SUGAR.language.get('app_strings', 'ERR_INVALID_VALUE');
    nomatchTxt = SUGAR.language.get('app_strings', 'ERR_SQS_NO_MATCH_FIELD');
    matchTxt = txt.replace(requiredTxt,'').replace(invalidTxt,'').replace(nomatchTxt,'');

        $(inputHandle).parent().children().each(function() {
            var $el = $(this);
            if($el.hasClass('required validation-message') && $el.text().indexOf(matchTxt) > 0) {
                raiseFlag = true;
            }
        });

    if(!raiseFlag) {
        errorTextNode = document.createElement('div');
        errorTextNode.className = 'required validation-message';
        errorTextNode.innerHTML = txt;
        if ( inputHandle.parentNode.className.indexOf('x-form-field-wrap') != -1 ) {
            inputHandle.parentNode.parentNode.appendChild(errorTextNode);
        }
        else {
            inputHandle.parentNode.appendChild(errorTextNode);
        }
        if (flash)
        	inputHandle.style.backgroundColor = "#FF0000";
        inputsWithErrors.push(inputHandle);
	}
    if (flash)
    {
		// We only need to setup the flashy-flashy on the first entry, it loops through all fields automatically
	    if ( inputsWithErrors.length == 1 ) {
	      for(var wp = 1; wp <= 10; wp++) {
	        window.setTimeout('fade_error_style(style, '+wp*10+')',1000+(wp*50));
	      }
	    }
		if(typeof (window[formname + "_tabs"]) != "undefined") {
	        var tabView = window[formname + "_tabs"];
	        var parentDiv = YAHOO.util.Dom.getAncestorByTagName(inputHandle, "div");
	        if ( tabView.get ) {
	            var tabs = tabView.get("tabs");
	            for (var i in tabs) {
	                if (tabs[i].get("contentEl") == parentDiv
	                		|| YAHOO.util.Dom.isAncestor(tabs[i].get("contentEl"), inputHandle))
	                {
	                    tabs[i].get("labelEl").style.color = "red";
	                    if ( inputsWithErrors.length == 1 )
	                        tabView.selectTab(i);
	                }
	            }
	        }
		}
		window.setTimeout("inputsWithErrors[" + (inputsWithErrors.length - 1) + "].style.backgroundColor = '';", 2000);
    }

  } catch ( e ) {
      // Catch errors here so we don't allow an incomplete record through the javascript validation
  }
}


/**
 * removes all error messages for the current form
 */
function clear_all_errors() {
    for(var wp = 0; wp < inputsWithErrors.length; wp++) {
        if(typeof(inputsWithErrors[wp]) !='undefined' && typeof inputsWithErrors[wp].parentNode != 'undefined' && inputsWithErrors[wp].parentNode != null) {
            if ( inputsWithErrors[wp].parentNode.className.indexOf('x-form-field-wrap') != -1 )
            {
                inputsWithErrors[wp].parentNode.parentNode.removeChild(inputsWithErrors[wp].parentNode.parentNode.lastChild);
            }
            else
            {
                inputsWithErrors[wp].parentNode.removeChild(inputsWithErrors[wp].parentNode.lastChild);
            }
        }
	}
	if (inputsWithErrors.length == 0) return;

	if ( YAHOO.util.Dom.getAncestorByTagName(inputsWithErrors[0], "form") ) {
        var formname = YAHOO.util.Dom.getAncestorByTagName(inputsWithErrors[0], "form").getAttribute("name");
        if(typeof (window[formname + "_tabs"]) != "undefined") {
            var tabView = window[formname + "_tabs"];
            if ( tabView.get ) {
                var tabs = tabView.get("tabs");
                for (var i in tabs) {
                    if (typeof tabs[i] == "object")
                    tabs[i].get("labelEl").style.color = "";
                }
            }
        }
        inputsWithErrors = new Array();
    }
}

function get_current_bgcolor(input) {
	if(input.currentStyle) {// ie
		style = input.currentStyle.backgroundColor;
		return style.substring(1,7);
	}
	else {// moz
		style = '';
		styleRGB = document.defaultView.getComputedStyle(input, '').getPropertyValue("background-color");
		comma = styleRGB.indexOf(',');
		style += dec2hex(styleRGB.substring(4, comma));
		commaPrevious = comma;
		comma = styleRGB.indexOf(',', commaPrevious+1);
		style += dec2hex(styleRGB.substring(commaPrevious+2, comma));
		style += dec2hex(styleRGB.substring(comma+2, styleRGB.lastIndexOf(')')));
		return style;
	}
}

function hex2dec(hex){return(parseInt(hex,16));}
var hexDigit=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
function dec2hex(dec){return(hexDigit[dec>>4]+hexDigit[dec&15]);}

function fade_error_style(normalStyle, percent) {
	errorStyle = 'c60c30';
	var r1 = hex2dec(errorStyle.slice(0,2));
	var g1 = hex2dec(errorStyle.slice(2,4));
	var b1 = hex2dec(errorStyle.slice(4,6));

	var r2 = hex2dec(normalStyle.slice(0,2));
	var g2 = hex2dec(normalStyle.slice(2,4));
	var b2 = hex2dec(normalStyle.slice(4,6));


	var pc = percent / 100;

	r= Math.floor(r1+(pc*(r2-r1)) + .5);
	g= Math.floor(g1+(pc*(g2-g1)) + .5);
	b= Math.floor(b1+(pc*(b2-b1)) + .5);

	for(var wp = 0; wp < inputsWithErrors.length; wp++) {
		inputsWithErrors[wp].style.backgroundColor = "#" + dec2hex(r) + dec2hex(g) + dec2hex(b);
	}
}

function isFieldTypeExceptFromEmptyCheck(fieldType)
{
    var results = false;
    var exemptList = ['bool','file','checkboxset'];
    for(var i=0;i<exemptList.length;i++)
    {
        if(fieldType == exemptList[i])
            return true;
    }
    return results;
}
function isFieldHidden(field, type)
{
    var Dom = YAHOO.util.Dom;
    if (Dom.getAttribute(field, "type") == "hidden" && type != "datetimecombo") {
        return true;
    }

	var td = Dom.getAncestorByTagName(field, 'TD');

    // For 'datetime' field type html representation differ from others ( td.vis_action_hidden > table > td > input[name])
    if (type == 'date' && !Dom.hasClass(td, 'vis_action_hidden')) {
        td = Dom.getAncestorByTagName(td, 'TD');
    }

    return Dom.hasClass(td, 'vis_action_hidden');
}
function validate_form(formname, startsWith){
    requiredTxt = SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS');
    invalidTxt = SUGAR.language.get('app_strings', 'ERR_INVALID_VALUE');

	if ( typeof (formname) == 'undefined')
	{
		return false;
	}
	if ( typeof (validate[formname]) == 'undefined')
	{
//        disableOnUnloadEditView(document.forms[formname]);
		return true;
	}

	var form = document.forms[formname];
	var isError = false;
	var errorMsg = "";
	var _date = new Date();
	if(_date.getTime() < (lastSubmitTime + 2000) && startsWith == oldStartsWith) { // ignore submits for the next 2 seconds
		return false;
	}
	lastSubmitTime = _date.getTime();
	oldStartsWith = startsWith;

	clear_all_errors(); // remove previous error messages

	inputsWithErrors = new Array();
	for(var i = 0; i < validate[formname].length; i++){
			if(validate[formname][i][nameIndex].indexOf(startsWith) == 0){
				if(typeof form[validate[formname][i][nameIndex]]  != 'undefined' && typeof form[validate[formname][i][nameIndex]].value != 'undefined'){
					var bail = false;

					//If a field is hidden, skip validation.
					var field = form[validate[formname][i][nameIndex]];
					if ((isFieldHidden(field, validate[formname][i][typeIndex]) && validate[formname][i][typeIndex] != 'file' && field.id != 'tiny_vals') || field.disabled)
					{
						continue;
					}

                    //If a field is not required and it is blank or is binarydependant, skip validation.
                    //Example of binary dependant fields would be the hour/min/meridian dropdowns in a date time combo widget, which require further processing than a blank check
                    if(!validate[formname][i][requiredIndex] && trim(form[validate[formname][i][nameIndex]].value) == '' && (typeof(validate[formname][i][jstypeIndex]) != 'undefined' && validate[formname][i][jstypeIndex]  != 'binarydep'))
                    {
                       continue;
                    }

					if(validate[formname][i][requiredIndex]
						&& !isFieldTypeExceptFromEmptyCheck(validate[formname][i][typeIndex])
					){
						if(typeof form[validate[formname][i][nameIndex]] === 'undefined' || trim(form[validate[formname][i][nameIndex]].value) === ""){
							add_error_style(formname, validate[formname][i][nameIndex], requiredTxt +' ' + validate[formname][i][msgIndex]);
							isError = true;
						}
					}
					if(!bail){
						switch(validate[formname][i][typeIndex]){
						case 'email':
							if(!isValidEmail(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							 break;
						case 'time':
							if( !isTime(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							} break;
						case 'date': if(!isDate(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}  break;
						case 'alpha':
							break;
						case 'DBName':
							if(!isDBName(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							break;
                        // Bug #49614 : Check value without trimming before
						case 'DBNameRaw':
							if(!isDBName(form[validate[formname][i][nameIndex]].value)){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							break;
						case 'alphanumeric':
							break;
						case 'file':
						    var file_input = form[validate[formname][i][nameIndex] + '_file'];
                            if( file_input && validate[formname][i][requiredIndex] && trim(file_input.value) == "" && !file_input.disabled ) {
						          isError = true;
						          add_error_style(formname, validate[formname][i][nameIndex], requiredTxt + " " +	validate[formname][i][msgIndex]);
						      }
						  break;
						case 'int':
							if(!isInteger(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							break;
						case 'decimal':
							if(!isDecimal(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							break;
						case 'currency':
						case 'float':
							if(!isFloat(trim(form[validate[formname][i][nameIndex]].value))){
								isError = true;
								add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
							}
							break;
						case 'teamset_mass':
							var div_element_id = formname + '_' + form[validate[formname][i][nameIndex]].name + '_operation_div';
							var input_elements = YAHOO.util.Selector.query('input', document.getElementById(div_element_id));
							var primary_field_id = '';
							var validation_passed = false;
							var replace_selected = false;

							//Loop through the option elements (replace or add currently)
							for(t in input_elements) {
								if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true && input_elements[t].value == 'replace') {

						           //Now find where the primary radio button is and if a value has been set
						           var radio_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(formname + '_team_name_table'));

						           for(var x = 0; x < radio_elements.length; x++) {
						        	   if(radio_elements[x].name != 'team_name_type') {
						        		  primary_field_id = 'team_name_collection_' + radio_elements[x].value;
						        		  if(radio_elements[x].checked) {
						        			  replace_selected = true;
						        			  if(trim(document.forms[formname].elements[primary_field_id].value) != '') {
		                                         validation_passed = true;
		                                         break;
										      }
						        		  } else if(trim(document.forms[formname].elements[primary_field_id].value) != '') {
						        			  replace_selected = true;
						        		  }
						        	   }
								   }
						        }
							}

							if(replace_selected && !validation_passed) {
						       add_error_style(formname, primary_field_id, SUGAR.language.get('app_strings', 'ERR_NO_PRIMARY_TEAM_SPECIFIED'));
						       isError = true;
							}
							break;
						case 'teamset':
							   var table_element_id = formname + '_' + form[validate[formname][i][nameIndex]].name + '_table';
							   if(document.getElementById(table_element_id)) {
								   var input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
								   var has_primary = false;
								   var primary_field_id = form[validate[formname][i][nameIndex]].name + '_collection_0';

								   for(t in input_elements) {
									    primary_field_id = form[validate[formname][i][nameIndex]].name + '_collection_' + input_elements[t].value;
								        if(input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
								           if(document.forms[formname].elements[primary_field_id].value != '') {
								        	  has_primary = true;
								           }
								           break;
								        }
								   }

								   if(!has_primary) {
									  isError = true;
									  var field_id = form[validate[formname][i][nameIndex]].name + '_collection_' + input_elements[0].value;
									  add_error_style(formname, field_id, SUGAR.language.get('app_strings', 'ERR_NO_PRIMARY_TEAM_SPECIFIED'));
								   }
							   }
						       break;
						case 'checkboxset':
							var validation_passed = false;
							var input_elements = YAHOO.util.Selector.query('input[name="'+validate[formname][i][nameIndex]+'"]', document.getElementById(formname));
    
							for (t in input_elements) {
							    if (input_elements[t].type && input_elements[t].type == 'checkbox' && input_elements[t].checked == true) {
							        validation_passed = true;
							        break;
							    }
							}

							if (!validation_passed) {
							    isError = true;
							    var elements = $(input_elements).closest('.checkboxset').find('input');
							    add_error_style(formname, elements[0], requiredTxt + " " + validate[formname][i][msgIndex]);
							}
							break;
					    case 'error':
							isError = true;
                            add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex]);
							break;
						}

						if(typeof validate[formname][i][jstypeIndex]  != 'undefined'/* && !isError*/){

							switch(validate[formname][i][jstypeIndex]){
                                // Bug #47961 May be validation through callback is best way.
                                case 'callback' :
                                    if (typeof validate[formname][i][callbackIndex] == 'function')
                                    {
                                        var result = validate[formname][i][callbackIndex](formname, validate[formname][i][nameIndex], i);
                                        if (result == false)
                                        {
                                            isError = true;
                                            add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex]);
                                        }
                                    }
                                    break;
							case 'range':
								if(!inRange(trim(form[validate[formname][i][nameIndex]].value), validate[formname][i][minIndex], validate[formname][i][maxIndex])){
									isError = true;
                                    var lbl_validate_range = SUGAR.language.get('app_strings', 'LBL_VALIDATE_RANGE');
                                    if (typeof validate[formname][i][minIndex] == 'number' && typeof validate[formname][i][maxIndex] == 'number')
                                    {
                                        add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] + " value " + form[validate[formname][i][nameIndex]].value + " " + lbl_validate_range + " (" +validate[formname][i][minIndex] + " - " + validate[formname][i][maxIndex] +  ")");
                                    }
                                    else if (typeof validate[formname][i][minIndex] == 'number')
                                    {
                                        add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] + " " + SUGAR.language.get('app_strings', 'MSG_SHOULD_BE') + ' ' + validate[formname][i][minIndex] + ' ' + SUGAR.language.get('app_strings', 'MSG_OR_GREATER'));
                                    }
                                    else if (typeof validate[formname][i][maxIndex] == 'number')
                                    {
                                        add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] + " " + SUGAR.language.get('app_strings', 'MSG_IS_MORE_THAN') + ' ' + validate[formname][i][maxIndex]);
                                    }
								}
							break;
							case 'isbefore':
								compareTo = form[validate[formname][i][compareToIndex]];
								if(	typeof compareTo != 'undefined'){
									if(trim(compareTo.value) != '' || (validate[formname][i][allowblank] != 'true') ) {
										date2 = trim(compareTo.value);
										date1 = trim(form[validate[formname][i][nameIndex]].value);

										if(trim(date1).length != 0 && !isBefore(date1,date2)){

											isError = true;
											//jc:#12287 - adding translation for the is not before message
											add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] + "(" + date1 + ") " + SUGAR.language.get('app_strings', 'MSG_IS_NOT_BEFORE') + ' ' +date2);
										}
									}
								}
							break;
                            case 'less':
                                value=unformatNumber(trim(form[validate[formname][i][nameIndex]].value), num_grp_sep, dec_sep);
								maximum = parseFloat(validate[formname][i][maxIndex]);
								if(	typeof maximum != 'undefined'){
									if(value>maximum) {
                                        isError = true;
                                        add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] +" " +SUGAR.language.get('app_strings', 'MSG_IS_MORE_THAN')+ ' ' + validate[formname][i][altMsgIndex]);
                                    }
								}
							break;
							case 'more':
                                value=unformatNumber(trim(form[validate[formname][i][nameIndex]].value), num_grp_sep, dec_sep);
								minimum = parseFloat(validate[formname][i][minIndex]);
								if(	typeof minimum != 'undefined'){
									if(value<minimum) {
                                        isError = true;
                                        add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex] +" " +SUGAR.language.get('app_strings', 'MSG_SHOULD_BE')+ ' ' + minimum + ' ' + SUGAR.language.get('app_strings', 'MSG_OR_GREATER'));
                                    }
								}
							break;
                            case 'binarydep':
								compareTo = form[validate[formname][i][compareToIndex]];
								if( typeof compareTo != 'undefined') {
									item1 = trim(form[validate[formname][i][nameIndex]].value);
									item2 = trim(compareTo.value);
									if(!bothExist(item1, item2)) {
										isError = true;
										add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex]);
									}
								}
							break;
							case 'comparison':
								compareTo = form[validate[formname][i][compareToIndex]];
								if( typeof compareTo != 'undefined') {
									item1 = trim(form[validate[formname][i][nameIndex]].value);
									item2 = trim(compareTo.value);
									if(!bothExist(item1, item2) || item1 != item2) {
										isError = true;
										add_error_style(formname, validate[formname][i][nameIndex], validate[formname][i][msgIndex]);
									}
								}
							break;
							case 'in_array':
								arr = eval(validate[formname][i][arrIndex]);
								operator = validate[formname][i][operatorIndex];
								item1 = trim(form[validate[formname][i][nameIndex]].value);
								if (operator.charAt(0) == 'u') {
									item1 = item1.toUpperCase();
									operator = operator.substring(1);
								} else if (operator.charAt(0) == 'l') {
									item1 = item1.toLowerCase();
									operator = operator.substring(1);
								}
								for(j = 0; j < arr.length; j++){
									val = arr[j];
									if((operator == "==" && val == item1) || (operator == "!=" && val != item1)){
										isError = true;
										add_error_style(formname, validate[formname][i][nameIndex], invalidTxt + " " +	validate[formname][i][msgIndex]);
									}
								}
							break;
							case 'verified':
							if(trim(form[validate[formname][i][nameIndex]].value) == 'false'){
							   //Fake an error so form does not submit
							   isError = true;
							}
							break;
							}
						}
					}
				}
			}
		}
/*	nsingh: BUG#15102
	Check min max default field logic.
	Can work with float values as well, but as of 10/8/07 decimal values in MB and studio don't have min and max value constraints.*/
	if(formsWithFieldLogic){
		var invalidLogic=false;
		if(formsWithFieldLogic.min && formsWithFieldLogic.max && formsWithFieldLogic._default) {
			var showErrorsOn={min:{value:'min', show:false, obj:formsWithFieldLogic.min.value},
							max:{value:'max',show:false, obj:formsWithFieldLogic.max.value},
							_default:{value:'default',show:false, obj:formsWithFieldLogic._default.value},
                              len:{value:'len', show:false, obj:parseInt(formsWithFieldLogic.len.value,10)}};

			var min = (formsWithFieldLogic.min.value !='') ? parseFloat(formsWithFieldLogic.min.value) : 'undef';
			var max  = (formsWithFieldLogic.max.value !='') ? parseFloat(formsWithFieldLogic.max.value) : 'undef';
			var _default = (formsWithFieldLogic._default.value!='')? parseFloat(formsWithFieldLogic._default.value) : 'undef';

			/*Check all lengths are <= max size.*/
			for(var i in showErrorsOn){
				if(showErrorsOn[i].value!='len' && showErrorsOn[i].obj.length > showErrorsOn.len.obj){
					invalidLogic=true;
					showErrorsOn[i].show=true;
					showErrorsOn.len.show=true;
				}
			}

			if(min!='undef' && max!='undef' && _default!='undef'){
				if(!inRange(_default,min,max)){
					invalidLogic=true;
					showErrorsOn.min.show=true;
					showErrorsOn.max.show=true;
					showErrorsOn._default.show=true;
				}
			}
			if(min!='undef' && max!= 'undef' && min > max){
				invalidLogic = true;
				showErrorsOn.min.show=true;
				showErrorsOn.max.show=true;
			}
			if(min!='undef' && _default!='undef' && _default < min){

				invalidLogic = true;
				showErrorsOn.min.show=true;
				showErrorsOn._default.show=true;
			}
			if(max!='undef' && _default !='undef' && _default>max){

				invalidLogic = true;
				showErrorsOn.max.show=true;
				showErrorsOn._default.show=true;
			}

			if(invalidLogic){
				isError=true;
				for(var error in showErrorsOn)
					if(showErrorsOn[error].show)
						add_error_style(formname,showErrorsOn[error].value, formsWithFieldLogic.msg);

			}

			else if (!isError)
				formsWithFieldLogic = null;
		}
	}
	if(formWithPrecision){
		if (!isValidPrecision(formWithPrecision.float.value, formWithPrecision.precision.value)){
			isError = true;
			add_error_style(formname, 'default', SUGAR.language.get('app_strings', 'ERR_COMPATIBLE_PRECISION_VALUE'));
		}else if(!isError){
			isError = false;
		}
	}

//END BUG# 15102

	if (isError == true) {
		var nw, ne, sw, se;
		if (self.pageYOffset) // all except Explorer
		{
			nwX = self.pageXOffset;
			seX = self.innerWidth;
			nwY = self.pageYOffset;
			seY = self.innerHeight;
		}
		else if (document.documentElement && document.documentElement.scrollTop) // Explorer 6 Strict
		{
			nwX = document.documentElement.scrollLeft;
			seX = document.documentElement.clientWidth;
			nwY = document.documentElement.scrollTop;
			seY = document.documentElement.clientHeight;
		}
		else if (document.body) // all other Explorers
		{
			nwX = document.body.scrollLeft;
			seX = document.body.clientWidth;
			nwY = document.body.scrollTop;
			seY = document.body.clientHeight;
		}

		var inView = true; // is there an error within viewport of browser
		for(var wp = 0; wp < inputsWithErrors.length; wp++) {
			var elementCoor = findElementPos(inputsWithErrors[wp]);
			if(!(elementCoor.x >= nwX && elementCoor.y >= nwY &&
                elementCoor.x <= seX+nwX && elementCoor.y <= seY+nwY)) { // if input is not within viewport, modify for SI bug 52497
					inView = false;
					scrollToTop = elementCoor.y - 75;
					scrollToLeft = elementCoor.x - 75;
			}
			else { // on first input within viewport, don't scroll
				break;
			}
		}


		if(!inView) window.scrollTo(scrollToLeft,scrollToTop);

		return false;
	}

//    disableOnUnloadEditView(form);
	return true;

}


/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;


/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor) {
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || (currentColor!= null && (currentColor.toLowerCase() == theDefaultColor.toLowerCase()))) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor!= null && (currentColor.toLowerCase() == thePointerColor.toLowerCase())
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor!= null && (currentColor.toLowerCase() == theMarkColor.toLowerCase())) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function


/**
  * listbox redirection
  */
function goToUrl(selObj, goToLocation) {
    eval("document.location.href = '" + goToLocation + "pos=" + selObj.options[selObj.selectedIndex].value + "'");
}



var json_objects = new Object();

function getXMLHTTPinstance() {
    var xmlhttp = false;
    var userAgent = navigator.userAgent.toLowerCase();

    // IE Check supports ActiveX controls
    if ($.browser.msie) {
        var version = $.browser.version;
        if (version >= 5.5) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (E) {
                    xmlhttp = false;
                }
            }
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

// NOW LOAD THE OBJECT..
var global_xmlhttp = getXMLHTTPinstance();

function http_fetch_sync(url,post_data) {
	global_xmlhttp = getXMLHTTPinstance();
	var method = 'GET';

	if(typeof(post_data) != 'undefined') method = 'POST';
	try {
		global_xmlhttp.open(method, url,false);
	}
	catch(e) {
		alert('message:'+e.message+":url:"+url);
	}
	if(method == 'POST') {
		global_xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}

	global_xmlhttp.send(post_data);

	if (SUGAR.util.isLoginPage(global_xmlhttp.responseText))
		return false;

	var args = {"responseText" : global_xmlhttp.responseText,
				"responseXML" : global_xmlhttp.responseXML,
				"request_id" : typeof(request_id) != "undefined" ? request_id : 0};
	return args;

}
// this is a GET unless post_data is defined

function http_fetch_async(url,callback,request_id,post_data) {
	var method = 'GET';
	if(typeof(post_data) != 'undefined') {
		method = 'POST';
	}

	try {
		global_xmlhttp.open(method, url,true);
	}
	catch(e) {
		alert('message:'+e.message+":url:"+url);
	}
	if(method == 'POST') {
		global_xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}
	global_xmlhttp.onreadystatechange = function() {
		if(global_xmlhttp.readyState==4) {
			if(global_xmlhttp.status == 200) {
				if (SUGAR.util.isLoginPage(global_xmlhttp.responseText))
					return false;
				var args = {"responseText" : global_xmlhttp.responseText,
							"responseXML" : global_xmlhttp.responseXML,
							"request_id" : request_id };
				callback.call(document,args);
			}
			else {
				alert("There was a problem retrieving the XML data:\n" + global_xmlhttp.statusText);
			}
		}
	}
	global_xmlhttp.send(post_data);
}

function insert_at_cursor(field, value) {
 //ie:
	if (document.selection) {
		field.focus();
		sel = document.selection.createRange();
		sel.text = value;
	}
 //mozilla:
	else if(field.selectionStart || field.selectionStart == '0') {
		var start_pos = field.selectionStart;
		var end_pos = field.selectionEnd;
		field.value = field.value.substring(0, start_pos) + value + field.value.substring(end_pos, field.value.length);
	}
	else {
		field.value += value;
	}
}

function checkParentType(type,button) {
	if(button == null) {
		return;
	}
	if(typeof disabledModules != 'undefined' && typeof(disabledModules[type]) != 'undefined') {
		button.disabled='disabled';
	}
	else {
		button.disabled = false;
	}
}

function parseDate(input, format) {
	date = input.value;
	format = format.replace(/%/g, '');
	sep = format.charAt(1);
	yAt = format.indexOf('Y')
	// 1-1-06 or 1-12-06 or 1-1-2006 or 1-12-2006
	if(date.match(/^\d{1,2}[\/-]\d{1,2}[\/-]\d{2,4}$/) && yAt == 4) {
		if(date.match(/^\d{1}[\/-].*$/)) date = '0' + date;
		if(date.match(/^\d{2}[\/-]\d{1}[\/-].*$/)) date = date.substring(0,3) + '0' + date.substring(3,date.length);
		if(date.match(/^\d{2}[\/-]\d{2}[\/-]\d{2}$/)) date = date.substring(0,6) + '20' + date.substring(6,date.length);
	}
	// 06-11-1 or 06-1-1
	else if(date.match(/^\d{2,4}[\/-]\d{1,2}[\/-]\d{1,2}$/)) {
		if(date.match(/^\d{2}[\/-].*$/)) date = '20' + date;
		if(date.match(/^\d{4}[\/-]\d{1}[\/-].*$/)) date = date.substring(0,5) + '0' + date.substring(5,date.length);
		if(date.match(/^\d{4}[\/-]\d{2}[\/-]\d{1}$/)) date = date.substring(0,8) + '0' + date.substring(8,date.length);
	}
	else if(date.match(/^\d{4,8}$/)) { // digits only
		digits = 0;
		if(date.match(/^\d{8}$/)) digits = 8;// match for 8 digits
		else if(date.match(/\d{6}/)) digits = 6;// match for 5 digits
		else if(date.match(/\d{4}/)) digits = 4;// match for 5 digits
		else if(date.match(/\d{5}/)) digits = 5;// match for 5 digits

		switch(yAt) {
			case 0:
				switch(digits) {
					case 4: date = '20' + date.substring(0,2) + sep + '0' + date.substring(2, 3) + sep + '0' + date.substring(3,4); break;
					case 5: date = '20' + date.substring(0,2) + sep + date.substring(2, 4) + sep + '0' + date.substring(4,5); break;
					case 6: date = '20' + date.substring(0,2) + sep + date.substring(2, 4) + sep + date.substring(4,6); break;
					case 8: date = date.substring(0,4) + sep + date.substring(4, 6) + sep + date.substring(6,8); break;
				}
				break;
			case 2:
				switch(digits) {
					case 4: date = '0' + date.substring(0,1) + sep + '20' + date.substring(1, 3) + sep + '0' + date.substring(3,4); break;
					case 5: date = date.substring(0,2) + sep + '20' + date.substring(2, 4) + sep + '0' + date.substring(4,5); break;
					case 6: date = date.substring(0,2) + sep + '20' + date.substring(2, 4) + sep + date.substring(4,6); break;
					case 8: date = date.substring(0,2) + sep + date.substring(2, 6) + sep + date.substring(6,8); break;
				}
			case 4:
				switch(digits) {
					case 4: date = '0' + date.substring(0,1) + sep + '0' + date.substring(1, 2) + sep + '20' + date.substring(2,4); break;
					case 5: date = '0' + date.substring(0,1) + sep + date.substring(1, 3) + sep + '20' + date.substring(3,5); break;
					case 6: date = date.substring(0,2) + sep + date.substring(2, 4) + sep + '20' + date.substring(4,6); break;
					case 8: date = date.substring(0,2) + sep + date.substring(2, 4) + sep + date.substring(4,8); break;
				}
				break;
		}
	}
	date = date.replace(/[\/-]/g, sep);
	input.value = date;
}

// find obj's position
function findElementPos(obj) {
    var x = 0;
    var y = 0;
    if (obj.offsetParent) {
      while (obj.offsetParent) {
        x += obj.offsetLeft;
        y += obj.offsetTop;
        obj = obj.offsetParent;
      }
    }//if offsetParent exists
    else if (obj.x && obj.y) {
      y += obj.y
      x += obj.x
    }
	return new coordinate(x, y);
}//findElementPos


// get dimensions of the browser window
function getClientDim() {
	var nwX, nwY, seX, seY;
	if (self.pageYOffset) // all except Explorer
	{
	  nwX = self.pageXOffset;
	  seX = self.innerWidth + nwX;
	  nwY = self.pageYOffset;
	  seY = self.innerHeight + nwY;
	}
	else if (document.documentElement && document.documentElement.scrollTop) // Explorer 6 Strict
	{
	  nwX = document.documentElement.scrollLeft;
	  seX = document.documentElement.clientWidth + nwX;
	  nwY = document.documentElement.scrollTop;
	  seY = document.documentElement.clientHeight + nwY;
	}
	else if (document.body) // all other Explorers
	{
	  nwX = document.body.scrollLeft;
	  seX = document.body.clientWidth + nwX;
	  nwY = document.body.scrollTop;
	  seY = document.body.clientHeight + nwY;
	}
	return {'nw' : new coordinate(nwX, nwY), 'se' : new coordinate(seX, seY)};
}

/**
* stop propagation on events
**/
function freezeEvent(e) {
	if(e) {
	  if (e.preventDefault) e.preventDefault();
	  e.returnValue = false;
	  e.cancelBubble = true;
	  if (e.stopPropagation) e.stopPropagation();
	  return false;
	}
}


/**
 * coordinate class
 **/
function coordinate(_x, _y) {
  var x = _x;
  var y = _y;
  this.add = add;
  this.sub = sub;
  this.x = x;
  this.y = y;

  function add(rh) {
    return new position(this.x + rh.x, this.y + rh.y);
  }

  function sub(rh) {
    return new position(this.x + rh.x, this.y + rh.y);
  }
}

// sends theForm via AJAX and fills in the theDiv
function sendAndRetrieve(theForm, theDiv, loadingStr) {
	function success(data) {
		document.getElementById(theDiv).innerHTML = data.responseText;
		ajaxStatus.hideStatus();
	}
	if(typeof loadingStr == 'undefined') SUGAR.language.get('app_strings', 'LBL_LOADING');
	ajaxStatus.showStatus(loadingStr);
    oForm = new YAHOO.util.Element(theForm);
    if ( oForm.get('enctype') && oForm.get('enctype') == 'multipart/form-data' ) {
        // the second argument is true to indicate file upload.
        YAHOO.util.Connect.setForm(theForm, true);
        var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {upload: success, failure: success});
    } else {
        YAHOO.util.Connect.setForm(theForm);
        var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {success: success, failure: success});
    }
	return false;
}

//save the form and redirect
function sendAndRedirect(theForm, loadingStr, redirect_location) {
	function success(data) {
		if(redirect_location){
			location.href=redirect_location;
		}
		ajaxStatus.hideStatus();
	}
	if(typeof loadingStr == 'undefined') SUGAR.language.get('app_strings', 'LBL_LOADING');
	ajaxStatus.showStatus(loadingStr);
    oForm = new YAHOO.util.Element(theForm);
    if ( oForm.get('enctype') && oForm.get('enctype') == 'multipart/form-data' ) {
        // the second argument is true to indicate file upload.
        YAHOO.util.Connect.setForm(theForm, true);
        var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {upload: success, failure: success});
    } else {
        YAHOO.util.Connect.setForm(theForm);
        var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {success: success, failure: success});
    }
	return false;
}

function saveForm(theForm, theDiv, loadingStr) {
	if(check_form(theForm)){
		for(i = 0; i < ajaxFormArray.length; i++){
			if(ajaxFormArray[i] == theForm){
				ajaxFormArray.splice(i, 1);
			}
		}
		return sendAndRetrieve(theForm, loadingStr, theDiv);
	}
	else
		return false;
}

// Builds a "snapshot" of the form, so we can use it to see if someone has changed it.
function snapshotForm(theForm) {
    var snapshotTxt = '';
    var elemList = theForm.elements;
    var elem;
    var elemType;

    for( var i = 0; i < elemList.length ; i++ ) {
        elem = elemList[i];
        if ( typeof(elem.type) == 'undefined' ) {
            continue;
        }

        elemType = elem.type.toLowerCase();

        snapshotTxt = snapshotTxt + elem.name;

        if ( elemType == 'text' || elemType == 'textarea' || elemType == 'password' ) {
            snapshotTxt = snapshotTxt + elem.value;
        }
        else if ( elemType == 'select' || elemType == 'select-one' || elemType == 'select-multiple' ) {
            var optionList = elem.options;
            for ( var ii = 0 ; ii < optionList.length ; ii++ ) {
                if ( optionList[ii].selected ) {
                    snapshotTxt = snapshotTxt + optionList[ii].value;
                }
            }
        }
        else if ( elemType == 'radio' || elemType == 'checkbox' ) {
            if ( elem.selected ) {
                snapshotTxt = snapshotTxt + 'checked';
            }
        }
        else if ( elemType == 'hidden' ) {
            if (elem.name=='edit_all_recurrences') {
                continue;
            }

            snapshotTxt = snapshotTxt + elem.value;
        }
    }

    return snapshotTxt;
}

// TODO remove this and check if there is more code that can be removed
//function initEditView(theForm) {
//    if (SUGAR.util.ajaxCallInProgress()) {
//    	window.setTimeout(function(){initEditView(theForm);}, 100);
//    	return;
//    }
//
//    if ( theForm == null || theForm.id == null ) {
//        // Not much we can do here.
//        return;
//    }
//
//    // we don't need to check if the data is changed in the search popup
//    if (theForm.id == 'popup_query_form' || theForm.id == 'MassUpdate') {
//    	return;
//    }
//	if ( typeof editViewSnapshots == 'undefined' || editViewSnapshots == null ) {
//        editViewSnapshots = new Object();
//    }
//    if ( typeof SUGAR.loadedForms == 'undefined' || SUGAR.loadedForms == null) {
//    	SUGAR.loadedForms = new Object();
//    }
//
//    editViewSnapshots[theForm.id] = snapshotForm(theForm);
//    SUGAR.loadedForms[theForm.id] = true;
//}
// TODO remove this and check if there is more code that can be removed
//function onUnloadEditView(theForm) {
//
//	var dataHasChanged = false;
//    if ( typeof editViewSnapshots == 'undefined' ) {
//        // No snapshots, move along
//        return;
//    }
//
//    if ( typeof theForm == 'undefined' ) {
//        // Need to check all editViewSnapshots
//        for ( var idx in editViewSnapshots ) {
//
//            theForm = document.getElementById(idx);
//            // console.log('DEBUG: Checking all forms '+theForm.id);
//            if ( theForm == null
//                 || typeof editViewSnapshots[theForm.id] == 'undefined'
//                 || editViewSnapshots[theForm.id] == null
//                 || !SUGAR.loadedForms[theForm.id]) {
//                continue;
//            }
//
//            var snap = snapshotForm(theForm);
//            if ( editViewSnapshots[theForm.id] != snap ) {
//                dataHasChanged = true;
//            }
//        }
//    } else {
//        // Just need to check a single form for changes
//		if ( editViewSnapshots == null  || typeof theForm.id == 'undefined' || typeof editViewSnapshots[theForm.id] == 'undefined' || editViewSnapshots[theForm.id] == null ) {
//            return;
//        }
//
//        // console.log('DEBUG: Checking one form '+theForm.id);
//        if ( editViewSnapshots[theForm.id] != snapshotForm(theForm) ) {
//            // Data has changed.
//        	dataHasChanged = true;
//        }
//    }
//
//    if ( dataHasChanged == true ) {
//    	return SUGAR.language.get('app_strings','WARN_UNSAVED_CHANGES');
//    } else {
//        return;
//    }
//
//}
// TODO remove this and check if there is more code that can be removed
//function disableOnUnloadEditView(theForm) {
//    // If you don't pass anything in, it disables all checking
//    if ( typeof theForm == 'undefined' || typeof editViewSnapshots == 'undefined' || theForm == null || editViewSnapshots == null) {
//        window.onbeforeunload = null;
//        editViewSnapshots = null;
//
//        // console.log('DEBUG: Disabling all edit view checks');
//
//    } else {
//        // Otherwise, it just disables it for this form
//        if ( typeof(theForm.id) != 'undefined' && typeof(editViewSnapshots[theForm.id]) != 'undefined' ) {
//            editViewSnapshots[theForm.id] = null;
//        }
//
//        // console.log('DEBUG : Disabling just checks for '+theForm.id);
//
//    }
//}

// TODO remove this and check if there is more code that can be removed
/*
* save some forms using an ajax call
* theForms - the ids of all of theh forms to save
* savingStr - the string to display when saving the form
* completeStr - the string to display when the form has been saved
*/
//function saveForms( savingStr, completeStr) {
//	index = 0;
//	theForms = ajaxFormArray;
//	function success(data) {
//		var theForm = document.getElementById(ajaxFormArray[0]);
//		document.getElementById('multiedit_'+theForm.id).innerHTML = data.responseText;
//		var saveAllButton = document.getElementById('ajaxsaveall');
//		ajaxFormArray.splice(index, 1);
//		if(saveAllButton && ajaxFormArray.length <= 1){
//    		saveAllButton.style.visibility = 'hidden';
//    	}
//		index++;
//		if(index == theForms.length){
//			ajaxStatus.showStatus(completeStr);
//    		window.setTimeout('ajaxStatus.hideStatus();', 2000);
//    		if(saveAllButton)
//    			saveAllButton.style.visibility = 'hidden';
//    	}
//
//
//	}
//	if(typeof savingStr == 'undefined') SUGAR.language.get('app_strings', 'LBL_LOADING');
//	ajaxStatus.showStatus(savingStr);
//
//	//loop through the forms saving each one
//	for(i = 0; i < theForms.length; i++){
//		var theForm = document.getElementById(theForms[i]);
//		if(check_form(theForm.id)){
//			theForm.action.value='AjaxFormSave';
//			YAHOO.util.Connect.setForm(theForm);
//			var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', {success: success, failure: success});
//		}else{
//			ajaxStatus.hideStatus();
//		}
//		lastSubmitTime = lastSubmitTime-2000;
//	}
//	return false;
//}

// -- start sugarListView class
// js functions used for ListView
function sugarListView() {
}


sugarListView.prototype.confirm_action = function(del) {
	if (del == 1) {
		return confirm( SUGAR.language.get('app_strings', 'NTC_DELETE_CONFIRMATION_NUM') + sugarListView.get_num_selected(true)  + SUGAR.language.get('app_strings', 'NTC_DELETE_SELECTED_RECORDS'));
	}
	else {
		return confirm( SUGAR.language.get('app_strings', 'NTC_UPDATE_CONFIRMATION_NUM') + sugarListView.get_num_selected(true)  + SUGAR.language.get('app_strings', 'NTC_DELETE_SELECTED_RECORDS'));
	}

}
sugarListView.get_num_selected = function (asString) {
    var result = 0;
    var selectCount = $("input[name='selectCount[]']:first");
    if(selectCount.length > 0) {
        if (asString) {
                result = selectCount.val();
        } else {
            result = parseInt(selectCount.val().replace("+", ""));
        }

    }

    return result;

}
sugarListView.update_count = function(count, add) {
	if(typeof document.MassUpdate != 'undefined') {
		the_form = document.MassUpdate;
		for(var wp = 0; wp < the_form.elements.length; wp++) {
			if(typeof the_form.elements[wp].name != 'undefined' && the_form.elements[wp].name == 'selectCount[]') {
				if(add)	{
					the_form.elements[wp].value = parseInt(the_form.elements[wp].value,10) + count;
					if (the_form.select_entire_list.value == 1 && the_form.show_plus.value) {
						the_form.elements[wp].value += '+';
					}
				} else {
					if (the_form.select_entire_list.value == 1 && the_form.show_plus.value) {
				        the_form.elements[wp].value = count + '+';
				    } else {
				        the_form.elements[wp].value = count;
				    }
				}
			}
		}
	}
}
sugarListView.prototype.use_external_mail_client = function(no_record_txt, module) {
	selected_records = sugarListView.get_checks_count();
	if(selected_records <1) {
		alert(no_record_txt);
        return false;
	}

    if (document.MassUpdate.select_entire_list.value == 1) {
		if (totalCount > 10) {
			alert(totalCountError);
			return;
		} // if
		select = false;
	}
	else if (document.MassUpdate.massall.checked == true)
		select = false;
	else
		select = true;
    sugarListView.get_checks();
    var ids = "";
    if(select) { // use selected items
		ids = document.MassUpdate.uid.value;
	}
	else { // use current page
		inputs = document.MassUpdate.elements;
		ar = new Array();
		for(i = 0; i < inputs.length; i++) {
			if(inputs[i].name == 'mass[]' && inputs[i].checked && typeof(inputs[i].value) != 'function') {
				ar.push(inputs[i].value);
			}
		}
		ids = ar.join(',');
	}
    YAHOO.util.Connect.asyncRequest("POST", "index.php?", {
        success: this.use_external_mail_client_callback
    }, SUGAR.util.paramsToUrl({
        module: "Emails",
        action: "Compose",
        listViewExternalClient: 1,
        action_module: module,
        uid: ids,
        to_pdf:1
    }));

	return false;
}

sugarListView.prototype.use_external_mail_client_callback = function(o)
{
    if (o.responseText)
        location.href = 'mailto:' + o.responseText;
}

sugarListView.prototype.send_form_for_emails = function(select, currentModule, action, no_record_txt,action_module,totalCount, totalCountError) {
	if ( typeof(SUGAR.config.email_sugarclient_listviewmaxselect) != 'undefined' ) {
	    maxCount = 10;
	}
	else {
	    maxCount = SUGAR.config.email_sugarclient_listviewmaxselect;
	}

    if (document.MassUpdate.select_entire_list.value == 1) {
		if (totalCount > maxCount) {
			alert(totalCountError);
			return;
		} // if
		select = false;
	}
	else if (document.MassUpdate.massall.checked == true)
		select = false;
	else
		select = true;

	sugarListView.get_checks();
	// create new form to post (can't access action property of MassUpdate form due to action input)
	var newForm = document.createElement('form');
	newForm.method = 'post';
	newForm.action = action;
	newForm.name = 'newForm';
	newForm.id = 'newForm';
	var uidTa = document.createElement('textarea');
	uidTa.name = 'uid';
	uidTa.style.display = 'none';

	if(select) { // use selected items
		uidTa.value = document.MassUpdate.uid.value;
	}
	else { // use current page
		inputs = document.MassUpdate.elements;
		ar = new Array();
		for(i = 0; i < inputs.length; i++) {
			if(inputs[i].name == 'mass[]' && inputs[i].checked && typeof(inputs[i].value) != 'function') {
				ar.push(inputs[i].value);
			}
		}
		uidTa.value = ar.join(',');
	}

	if(uidTa.value == '') {
		alert(no_record_txt);
		return false;
	}

	var selectedArray = uidTa.value.split(",");
	if(selectedArray.length > maxCount) {
		alert(totalCountError);
		return;
	} // if
	newForm.appendChild(uidTa);

	var moduleInput = document.createElement('input');
	moduleInput.name = 'module';
	moduleInput.type = 'hidden';
	moduleInput.value = currentModule;
	newForm.appendChild(moduleInput);

	var actionInput = document.createElement('input');
	actionInput.name = 'action';
	actionInput.type = 'hidden';
	actionInput.value = 'Compose';
	newForm.appendChild(actionInput);

	if (typeof action_module != 'undefined' && action_module!= '') {
		var actionModule = document.createElement('input');
		actionModule.name = 'action_module';
		actionModule.type = 'hidden';
		actionModule.value = action_module;
		newForm.appendChild(actionModule);
	}
	//return_info must follow this pattern."&return_module=Accounts&return_action=index"
	if (typeof return_info!= 'undefined' && return_info != '') {
		var params= return_info.split('&');
		if (params.length > 0) {
			for (var i=0;i< params.length;i++) {
				if (params[i].length > 0) {
					var param_nv=params[i].split('=');
					if (param_nv.length==2){
						returnModule = document.createElement('input');
						returnModule.name = param_nv[0];
						returnModule.type = 'hidden';
						returnModule.value = param_nv[1];
						newForm.appendChild(returnModule);
					}
				}
			}
		}
	}

	var isAjaxCall = document.createElement('input');
	isAjaxCall.name = 'ajaxCall';
	isAjaxCall.type = 'hidden';
	isAjaxCall.value = true;
	newForm.appendChild(isAjaxCall);

	var isListView = document.createElement('input');
	isListView.name = 'ListView';
	isListView.type = 'hidden';
	isListView.value = true;
	newForm.appendChild(isListView);

	var toPdf = document.createElement('input');
	toPdf.name = 'to_pdf';
	toPdf.type = 'hidden';
	toPdf.value = true;
	newForm.appendChild(toPdf);

	//Grab the Quick Compose package for the listview
    YAHOO.util.Connect.setForm(newForm);
    var callback =
	{
	  success: function(o) {
	      var resp = YAHOO.lang.JSON.parse(o.responseText);
	      var quickComposePackage = new Object();
	      quickComposePackage.composePackage = resp;
	      quickComposePackage.fullComposeUrl = 'index.php?module=Emails&action=Compose&ListView=true' +
	                                           '&uid=' + uidTa.value + '&action_module=' + action_module;

	      SUGAR.quickCompose.init(quickComposePackage);
	  }
	}

	YAHOO.util.Connect.asyncRequest('POST','index.php', callback,null);

	// awu Bug 18624: Fixing issue where a canceled Export and unselect of row will persist the uid field, clear the field
	document.MassUpdate.uid.value = '';

	return false;
}

sugarListView.prototype.send_form = function(select, currentModule, action, no_record_txt,action_module,return_info) {
	if (document.MassUpdate.select_entire_list.value == 1) {

		if(sugarListView.get_checks_count() < 1) {
		   alert(no_record_txt);
		   return false;
		}

		var href = action;
		if ( action.indexOf('?') != -1 )
			href += '&module=' + currentModule;
		else
			href += '?module=' + currentModule;

		if (return_info)
			href += return_info;
        var newForm = document.createElement('form');
        newForm.method = 'post';
        newForm.action = href;
        newForm.name = 'newForm';
        newForm.id = 'newForm';
        var postTa = document.createElement('textarea');
        postTa.name = 'current_post';
        postTa.value = document.MassUpdate.current_query_by_page.value;
        postTa.style.display = 'none';
        newForm.appendChild(postTa);
        document.MassUpdate.parentNode.appendChild(newForm);
        newForm.submit();
		return;
	}
	else if (document.MassUpdate.massall.checked == true)
		select = false;
	else
		select = true;

	sugarListView.get_checks();
	// create new form to post (can't access action property of MassUpdate form due to action input)
	var newForm = document.createElement('form');
	newForm.method = 'post';
	newForm.action = action;
	newForm.name = 'newForm';
	newForm.id = 'newForm';
	var uidTa = document.createElement('textarea');
	uidTa.name = 'uid';
	uidTa.style.display = 'none';
	uidTa.value = document.MassUpdate.uid.value;

	if(uidTa.value == '') {
		alert(no_record_txt);
		return false;
	}

	newForm.appendChild(uidTa);

	var moduleInput = document.createElement('input');
	moduleInput.name = 'module';
	moduleInput.type = 'hidden';
	moduleInput.value = currentModule;
	newForm.appendChild(moduleInput);

	var actionInput = document.createElement('input');
	actionInput.name = 'action';
	actionInput.type = 'hidden';
	actionInput.value = 'index';
	newForm.appendChild(actionInput);

	if (typeof action_module != 'undefined' && action_module!= '') {
		var actionModule = document.createElement('input');
		actionModule.name = 'action_module';
		actionModule.type = 'hidden';
		actionModule.value = action_module;
		newForm.appendChild(actionModule);
	}
	//return_info must follow this pattern."&return_module=Accounts&return_action=index"
	if (typeof return_info!= 'undefined' && return_info != '') {
		var params= return_info.split('&');
		if (params.length > 0) {
			for (var i=0;i< params.length;i++) {
				if (params[i].length > 0) {
					var param_nv=params[i].split('=');
					if (param_nv.length==2){
						returnModule = document.createElement('input');
						returnModule.name = param_nv[0];
						returnModule.type = 'hidden';
						returnModule.value = param_nv[1];
						newForm.appendChild(returnModule);
					}
				}
			}
		}
	}

	document.MassUpdate.parentNode.appendChild(newForm);

	newForm.submit();
	// awu Bug 18624: Fixing issue where a canceled Export and unselect of row will persist the uid field, clear the field
	document.MassUpdate.uid.value = '';

	return false;
}
//return a count of checked row.
sugarListView.get_checks_count = function() {
	ar = new Array();

	if(document.MassUpdate.uid.value != '') {
		oldUids = document.MassUpdate.uid.value.split(',');
		for(uid in oldUids) {
		    if(typeof(oldUids[uid]) != 'function') {
		       ar[oldUids[uid]] = 1;
		    }
		}
	}
	// build associated array of uids, associated array ensures uniqueness
	inputs = document.MassUpdate.elements;
	for(i = 0; i < inputs.length; i++) {
		if(inputs[i].name == 'mass[]') {
			ar[inputs[i].value]	= (inputs[i].checked) ? 1 : 0; // 0 of it is unchecked
	    }
	}

	// build regular array of uids
	uids = new Array();
	for(i in ar) {
		if((typeof(ar[i]) != 'function') && ar[i] == 1) {
		   uids.push(i);
		}
	}

	return uids.length;
}

// saves the checks on the current page into the uid textarea
sugarListView.get_checks = function() {
	ar = new Array();
	if(typeof document.MassUpdate != 'undefined' ){
	if(document.MassUpdate.uid.value != '') {
		oldUids = document.MassUpdate.uid.value.split(',');
		for(uid in oldUids) {
		    if(typeof(oldUids[uid]) != 'function') {
		       ar[oldUids[uid]] = 1;
		    }
		}
	}

	// build associated array of uids, associated array ensures uniqueness
	inputs = document.MassUpdate.elements;
	for(i = 0; i < inputs.length; i++) {
		if(inputs[i].name == 'mass[]') {
			ar[inputs[i].value]	= (inputs[i].checked) ? 1 : 0; // 0 of it is unchecked
		}
	}

	// build regular array of uids
	uids = new Array();
	for(i in ar) {
		if(typeof(ar[i]) != 'function' && ar[i] == 1) {
		   uids.push(i);
		}
	}

	document.MassUpdate.uid.value = uids.join(',');

	if(uids.length == 0) return false; // return false if no checks to get
	return true; // there are saved checks
	}
	else return false;
}

sugarListView.prototype.order_checks = function(order,orderBy,moduleString){
	checks = sugarListView.get_checks();
	eval('document.MassUpdate.' + moduleString + '.value = orderBy');
	document.MassUpdate.lvso.value = order;
	if(typeof document.MassUpdate.massupdate != 'undefined') {
	   document.MassUpdate.massupdate.value = 'false';
	}

	//we must first clear the action of massupdate, change it to index
   document.MassUpdate.action.value = document.MassUpdate.return_action.value;
   document.MassUpdate.return_module.value='';
   document.MassUpdate.return_action.value='';
   document.MassUpdate.submit();

	return !checks;
}
sugarListView.prototype.save_checks = function(offset, moduleString) {
	checks = sugarListView.get_checks();
	if(typeof document.MassUpdate != 'undefined'){
	eval('document.MassUpdate.' + moduleString + '.value = offset');

	if(typeof document.MassUpdate.massupdate != 'undefined') {
	   document.MassUpdate.massupdate.value = 'false';
	}

	//we must first clear the action of massupdate, change it to index
       document.MassUpdate.action.value = document.MassUpdate.return_action.value;
       document.MassUpdate.return_module.value='';
       document.MassUpdate.return_action.value='';
	   document.MassUpdate.submit();


	return !checks;
	}
	else return false;
}

sugarListView.prototype.check_item = function(cb, form) {
	if(cb.checked) {
		sugarListView.update_count(1, true);
        if(sugarListView.get_checks_count() == $(".checkbox").length -2)
        {
            $(".massall.checkbox").attr("checked", "checked");
        }

	}else{
		sugarListView.update_count(-1, true);
        $(".massall.checkbox").removeAttr("checked");
		if(typeof form != 'undefined' && form != null) {
			sugarListView.prototype.updateUid(cb, form);
		}
	}
	sugarListView.prototype.toggleSelected();
}

sugarListView.prototype.toggleSelected = function() {

	var numSelected = sugarListView.get_num_selected();
	var selectedRecords = document.getElementById("selectedRecordsTop");
	var selectActions = document.getElementById("selectActions");
	var selectActionsDisabled = document.getElementById("selectActionsDisabled");
	if(numSelected > 0) {
        $(selectedRecords).removeAttr("style").addClass("show");
        $(".selectActionsDisabled").hide();
        jQuery('ul[name=selectActions]').each(function () {
            jQuery(this).removeAttr("style").addClass("show");
        });

	} else {
        $(selectedRecords).hide();
        $(".selectActionsDisabled").removeAttr("style").addClass("show");
        jQuery('ul[name=selectActions]').each(function () {
            jQuery(this).hide();
        });
	}

}

/**#28000, remove the  unselect record id from MassUpdate.uid **/
sugarListView.prototype.updateUid = function(cb  , form){
    if(form.name == 'MassUpdate' && form.uid && form.uid.value && cb.value && form.uid.value.indexOf(cb.value) != -1){
        if(form.uid.value.indexOf(','+cb.value)!= -1){
            form.uid.value = form.uid.value.replace(','+cb.value , '');
        }else if(form.uid.value.indexOf(cb.value + ',')!= -1){
            form.uid.value = form.uid.value.replace(cb.value + ',' , '');
        }else if(form.uid.value.indexOf(cb.value)!= -1){
            form.uid.value = form.uid.value.replace(cb.value  , '');
        }
    }
}

sugarListView.prototype.check_entire_list = function(form, field, value, list_count) {
	// count number of items
	count = 0;
    $(document.MassUpdate.massall).each(function(){
            $(this).attr('checked', true).attr('disabled', true);
        });
	for (i = 0; i < form.elements.length; i++) {
		if(form.elements[i].name == field && form.elements[i].disabled == false) {
			if(form.elements[i].checked != value) count++;
				form.elements[i].checked = value;
				form.elements[i].disabled = true;
		}
	}
	document.MassUpdate.select_entire_list.value = 1;
	sugarListView.update_count(list_count, false);
    sugarListView.prototype.toggleSelected();
}

sugarListView.prototype.check_all = function(form, field, value, pageTotal) {
	// count number of items
	count = 0;
    $(document.MassUpdate.massall).each(function(){$(this).attr('checked', value);});
	if (document.MassUpdate.select_entire_list &&
		document.MassUpdate.select_entire_list.value == 1)
    {
        sugarListView.prototype.toggleSelected();
        $(document.MassUpdate.massall).each(function(){$(this).attr('disabled', true);});
	}
    else
    {
        $(document.MassUpdate.massall).each(function(){$(this).attr('disabled', false);});
    }
	for (i = 0; i < form.elements.length; i++) {
		if(form.elements[i].name == field && !(form.elements[i].disabled == true && form.elements[i].checked == false)) {
			form.elements[i].disabled = false;

			if(form.elements[i].checked != value)
				count++;
			form.elements[i].checked = value;
			if(!value){
				sugarListView.prototype.updateUid(form.elements[i], form);
			}
		}
	}
	if (pageTotal >= 0)
		sugarListView.update_count(pageTotal);
 	else if(value)
		sugarListView.update_count(count, true);
	else
		sugarListView.update_count(-1 * count, true);

	sugarListView.prototype.toggleSelected();
}
sugarListView.check_all = sugarListView.prototype.check_all;
sugarListView.confirm_action = sugarListView.prototype.confirm_action;

sugarListView.prototype.check_boxes = function() {
	var inputsCount = 0;
	var checkedCount = 0;
	var existing_onload = window.onload;
	var theForm = document.MassUpdate;
	inputs_array = theForm.elements;

	if(typeof theForm.uid.value != 'undefined' && theForm.uid.value != "") {
		checked_items = theForm.uid.value.split(",");
		if (theForm.select_entire_list.value == 1) {
			document.MassUpdate.massall.disabled = true;
            sugarListView.prototype.toggleSelected();
            $("a[name=selectall]:first").click();
        }

		for(var wp = 0 ; wp < inputs_array.length; wp++) {
			if(inputs_array[wp].name == "mass[]") {
				inputsCount++;
				if (theForm.select_entire_list.value == 1) {
					inputs_array[wp].checked = true;
					inputs_array[wp].disabled = true;
					checkedCount++;
				}
				else {
					for(i in checked_items) {
						if(inputs_array[wp].value == checked_items[i]) {
							checkedCount++;
							inputs_array[wp].checked = true;
                            //Bug#52748: Total # of checked items are calculated in back-end side
							//sugarListView.prototype.check_item(inputs_array[wp], document.MassUpdate);
						}
					}
				}
			}
		}
	}
	else {
		for(var wp = 0 ; wp < inputs_array.length; wp++) {
			if(inputs_array[wp].name == "mass[]") {
				inputs_array[wp].checked = false;
				inputs_array[wp].disabled = false;
			}
		}
		if (document.MassUpdate.massall) {
			document.MassUpdate.massall.checked = false;
			document.MassUpdate.massall.disabled = false;
		}
		sugarListView.update_count(0)
	}
	if(checkedCount > 0 && checkedCount == inputsCount)
		document.MassUpdate.massall.checked = true;
}


/**
 * This function is used in Email Template Module's listview.
 * It will check whether the templates are used in Campaing->EmailMarketing.
 * If true, it will notify user.
 */
function check_used_email_templates() {
	var ids = document.MassUpdate.uid.value;
	var call_back = {
		success:function(r) {
			if(r.responseText != '') {
				if(!confirm(SUGAR.language.get('app_strings','NTC_TEMPLATES_IS_USED') + r.responseText)) {
					return false;
				}
			}
			document.MassUpdate.submit();
			return false;
		}
		};
	url = "index.php?module=EmailTemplates&action=CheckDeletable&from=ListView&to_pdf=1&records="+ids;
	YAHOO.util.Connect.asyncRequest('POST',url, call_back,null);

}

sugarListView.prototype.send_mass_update = function(mode, no_record_txt, del) {
	formValid = check_form('MassUpdate');
	if(!formValid && !del) return false;


	if (document.MassUpdate.select_entire_list &&
		document.MassUpdate.select_entire_list.value == 1)
		mode = 'entire';
	else
		mode = 'selected';

	var ar = new Array();

	switch(mode) {
		case 'selected':
			for(var wp = 0; wp < document.MassUpdate.elements.length; wp++) {
				var reg_for_existing_uid = new RegExp('^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$|^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$');
				//when the uid is already in document.MassUpdate.uid.value, we should not add it to ar.
				if(typeof document.MassUpdate.elements[wp].name != 'undefined'
					&& document.MassUpdate.elements[wp].name == 'mass[]'
						&& document.MassUpdate.elements[wp].checked
						&& !reg_for_existing_uid.test(document.MassUpdate.uid.value)) {
							ar.push(document.MassUpdate.elements[wp].value);
				}
			}
			if(document.MassUpdate.uid.value != '') document.MassUpdate.uid.value += ',';
			document.MassUpdate.uid.value += ar.join(',');
			if(document.MassUpdate.uid.value == '') {
				alert(no_record_txt);
				return false;
			}
			if(typeof(document.MassUpdate.current_admin_id)!='undefined' && document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'Users' && (document.MassUpdate.UserType.value!='' || document.MassUpdate.status.value!='')) {
				var current_admin_id = document.MassUpdate.current_admin_id.value;
				var reg_for_current_admin_id = new RegExp('^'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'$|^'+current_admin_id+'$');
				if(reg_for_current_admin_id.test(document.MassUpdate.uid.value)) {
					//if current user is admin, we should not allow massupdate the user_type and status of himself
					alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));
					return false;
				}
			}
			break;
		case 'entire':
			var entireInput = document.createElement('input');
			entireInput.name = 'entire';
			entireInput.type = 'hidden';
			entireInput.value = 'index';
			document.MassUpdate.appendChild(entireInput);
			//confirm(no_record_txt);
			if(document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'Users' && (document.MassUpdate.UserType.value!='' || document.MassUpdate.status.value!='')) {
				alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));
				return false;
			}
			break;
	}

	if(!sugarListView.confirm_action(del))
		return false;

	if(del == 1) {
		var deleteInput = document.createElement('input');
		deleteInput.name = 'Delete';
		deleteInput.type = 'hidden';
		deleteInput.value = true;
		document.MassUpdate.appendChild(deleteInput);
		if(document.MassUpdate.module!= 'undefined' && document.MassUpdate.module.value == 'EmailTemplates') {
			check_used_email_templates();
			return false;
		}

	}

	document.MassUpdate.submit();
	return false;
}


sugarListView.prototype.clear_all = function() {
	document.MassUpdate.uid.value = '';
	document.MassUpdate.select_entire_list.value = 0;
	sugarListView.check_all(document.MassUpdate, 'mass[]', false);
    $(document.MassUpdate.massall).each(function(){
        $(this).attr('checked', false).attr('disabled', false);
    });
	sugarListView.update_count(0);
	sugarListView.prototype.toggleSelected();
}

sListView = new sugarListView();
// -- end sugarListView class

// format and unformat numbers
function unformatNumber(n, num_grp_sep, dec_sep) {
	var x=unformatNumberNoParse(n, num_grp_sep, dec_sep);
	x=x.toString();
	if(x.length > 0) {
		return parseFloat(x);
	}
	return '';
}

function unformatNumberNoParse(n, num_grp_sep, dec_sep) {
	if(typeof num_grp_sep == 'undefined' || typeof dec_sep == 'undefined') return n;
	n = n ? n.toString() : '';
	if(n.length > 0) {

	    if(num_grp_sep != '')
	    {
	       num_grp_sep_re = new RegExp('\\'+num_grp_sep, 'g');
		   n = n.replace(num_grp_sep_re, '');
	    }

		n = n.replace(dec_sep, '.');

        if(typeof CurrencySymbols != 'undefined') {
            // Need to strip out the currency symbols from the start.
            for ( var idx in CurrencySymbols ) {
                n = n.replace(CurrencySymbols[idx], '');
            }
        }
		return n;
	}
	return '';
}

// round parameter can be negative for decimal, precision has to be postive
function formatNumber(n, num_grp_sep, dec_sep, round, precision) {
  if(typeof num_grp_sep == 'undefined' || typeof dec_sep == 'undefined') return n;
  n = n ? n.toString() : '';
  if(n.split) n = n.split('.');
  else return n;

  if(n.length > 2) return n.join('.'); // that's not a num!
  // round
  if(typeof round != 'undefined') {
    if(round > 0 && n.length > 1) { // round to decimal
        n[1] = parseFloat('0.' + n[1]);
        n[1] = Math.round(n[1] * Math.pow(10, round)) / Math.pow(10, round);
        if (n[1] >= 1) {
            n[0] = n[0].indexOf('-') < 0 ? parseInt(n[0]) + parseInt(n[1]) : parseInt(n[0]) - parseInt(n[1]);
            n[0] = n[0].toString();
            n[1] = '';
        } else {
            n[1] = n[1].toString().split('.')[1];
        }
    }
    if(round <= 0) { // round to whole number
        n[0] = Math.round(parseInt(n[0],10) * Math.pow(10, round)) / Math.pow(10, round);
      n[1] = '';
    }
  }

  if(typeof precision != 'undefined' && precision >= 0) {
    if(n.length > 1 && typeof n[1] != 'undefined') n[1] = n[1].substring(0, precision); // cut off precision
	else n[1] = '';
    if(n[1].length < precision) {
      for(var wp = n[1].length; wp < precision; wp++) n[1] += '0';
    }
  }

  regex = /(\d+)(\d{3})/;
  while(num_grp_sep != '' && regex.test(n[0])) n[0] = n[0].toString().replace(regex, '$1' + num_grp_sep + '$2');
  return n[0] + (n.length > 1 && n[1] != '' ? dec_sep + n[1] : '');
}

// --- begin ajax status class
SUGAR.ajaxStatusClass = function() {};
SUGAR.ajaxStatusClass.prototype.statusDiv = null;
SUGAR.ajaxStatusClass.prototype.oldOnScroll = null;
SUGAR.ajaxStatusClass.prototype.shown = false; // state of the status window

// reposition the status div, top and centered
SUGAR.ajaxStatusClass.prototype.positionStatus = function() {
	//this.statusDiv.style.top = document.body.scrollTop + 8 + 'px';
	statusDivRegion = YAHOO.util.Dom.getRegion(this.statusDiv);
	statusDivWidth = statusDivRegion.right - statusDivRegion.left;
	this.statusDiv.style.left = YAHOO.util.Dom.getViewportWidth() / 2 - statusDivWidth / 2 + 'px';
}

// private func, create the status div
SUGAR.ajaxStatusClass.prototype.createStatus = function(text) {
	statusDiv = document.createElement('div');
	statusDiv.className = 'dataLabel';
	statusDiv.id = 'ajaxStatusDiv';
	document.body.appendChild(statusDiv);
	this.statusDiv = document.getElementById('ajaxStatusDiv');
}

// public - show the status div with text
SUGAR.ajaxStatusClass.prototype.showStatus = function(text) {
	if(!this.statusDiv) {
		this.createStatus(text);
	}
	else {
		this.statusDiv.style.display = '';
	}
	this.statusDiv.innerHTML = '&nbsp;<b>' + text + '</b>&nbsp;';
	this.positionStatus();
	if(!this.shown) {
		this.shown = true;
		this.statusDiv.style.display = '';
		if(window.onscroll) this.oldOnScroll = window.onscroll; // save onScroll
		window.onscroll = this.positionStatus;
	}
}

// public - hide it
SUGAR.ajaxStatusClass.prototype.hideStatus = function(text) {
	if(!this.shown) return;
	this.shown = false;
	if(this.oldOnScroll) window.onscroll = this.oldOnScroll;
	else window.onscroll = '';
	this.statusDiv.style.display = 'none';
}

SUGAR.ajaxStatusClass.prototype.flashStatus = function(text, time){
	this.showStatus(text);
	window.setTimeout('ajaxStatus.hideStatus();', time);
}


var ajaxStatus = new SUGAR.ajaxStatusClass();
// --- end ajax status class

/**
 * Unified Search Advanced - for global search
 */
SUGAR.unifiedSearchAdvanced = function() {
	var usa_div;
	var usa_img;
	var usa_open;
	var usa_content;
	var anim_open;
	var anim_close;

	return {
		init: function() {
			SUGAR.unifiedSearchAdvanced.usa_div = document.getElementById('unified_search_advanced_div');
			SUGAR.unifiedSearchAdvanced.usa_img = document.getElementById('unified_search_advanced_img');

			if(!SUGAR.unifiedSearchAdvanced.usa_div || !SUGAR.unifiedSearchAdvanced.usa_img) return;
			var attributes = { height: { to: 300 } };
            SUGAR.unifiedSearchAdvanced.anim_open = new YAHOO.util.Anim('unified_search_advanced_div', attributes );
			SUGAR.unifiedSearchAdvanced.anim_open.duration = 0.75;
			SUGAR.unifiedSearchAdvanced.anim_close = new YAHOO.util.Anim('unified_search_advanced_div', { height: {to: 0} } );
			SUGAR.unifiedSearchAdvanced.anim_close.duration = 0.75;
			//SUGAR.unifiedSearchAdvanced.anim_close.onComplete.subscribe(function() {SUGAR.unifiedSearchAdvanced.usa_div.style.display = 'none'});

			SUGAR.unifiedSearchAdvanced.usa_img._x = YAHOO.util.Dom.getX(SUGAR.unifiedSearchAdvanced.usa_img);
			SUGAR.unifiedSearchAdvanced.usa_img._y = YAHOO.util.Dom.getY(SUGAR.unifiedSearchAdvanced.usa_img);


			SUGAR.unifiedSearchAdvanced.usa_open = false;
			SUGAR.unifiedSearchAdvanced.usa_content = null;

		   YAHOO.util.Event.addListener('unified_search_advanced_img', 'click', SUGAR.unifiedSearchAdvanced.get_content);
		},

		get_content: function(e)
		{
		    query_string = trim(document.getElementById('query_string').value);
		    if(query_string != '')
		    {
		    	window.location.href = 'index.php?module=Home&action=UnifiedSearch&query_string=' + query_string;
		    } else {
		        window.location.href = 'index.php?module=Home&action=UnifiedSearch&form_only=true';
		    }
	    },

		animate: function(data) {
			ajaxStatus.hideStatus();

			if(data) {
				SUGAR.unifiedSearchAdvanced.usa_content = data.responseText;
				SUGAR.unifiedSearchAdvanced.usa_div.innerHTML = SUGAR.unifiedSearchAdvanced.usa_content;
			}
			if(SUGAR.unifiedSearchAdvanced.usa_open) {
				document.UnifiedSearch.advanced.value = 'false';
				SUGAR.unifiedSearchAdvanced.anim_close.animate();
			}
			else {
				document.UnifiedSearch.advanced.value = 'true';
				SUGAR.unifiedSearchAdvanced.usa_div.style.display = '';
				YAHOO.util.Dom.setX(SUGAR.unifiedSearchAdvanced.usa_div, SUGAR.unifiedSearchAdvanced.usa_img._x - 90);
				YAHOO.util.Dom.setY(SUGAR.unifiedSearchAdvanced.usa_div, SUGAR.unifiedSearchAdvanced.usa_img._y + 15);
				SUGAR.unifiedSearchAdvanced.anim_open.animate();
			}
	      	SUGAR.unifiedSearchAdvanced.usa_open = !SUGAR.unifiedSearchAdvanced.usa_open;

			return false;
		},

		checkUsaAdvanced: function() {
			if(document.UnifiedSearch.advanced.value == 'true') {
				document.UnifiedSearchAdvanced.query_string.value = document.UnifiedSearch.query_string.value;
				document.UnifiedSearchAdvanced.submit();
				return false;
			}
			return true;
		}
};
}();
if(typeof YAHOO != 'undefined') YAHOO.util.Event.addListener(window, 'load', SUGAR.unifiedSearchAdvanced.init);


SUGAR.ui = {
	/**
	 * Toggles the header
	 */
	toggleHeader : function() {
		var h = document.getElementById('header');

		if(h != null) {
			if(h != null) {
				if(h.style.display == 'none') {
					h.style.display = '';
				} else {
					h.style.display = 'none';
				}
			}
		} else {
			alert(SUGAR.language.get("app_strings", "ERR_NO_HEADER_ID"));
		}
	}
};


/**
 * General Sugar Utils
 */
SUGAR.util = function () {
	var additionalDetailsCache;
	var additionalDetailsCalls;
	var additionalDetailsRpcCall;

	return {
		getAndRemove : function (el) {
			if (YAHOO && YAHOO.util && YAHOO.util.Dom)
				el = YAHOO.util.Dom.get(el);
			else if (typeof (el) == "string")
				el = document.getElementById(el);
			if (el && el.parentNode)
				el.parentNode.removeChild(el);

			return el;
		},
        paramsToUrl : function (params) {
            var parts = [];
            for (var i in params)
            {
                if (params.hasOwnProperty(i))
                {
                    parts.push(encodeURIComponent(i) + '=' + encodeURIComponent(params[i]));
                }
            }
            return parts.join("&")+"&";
        },
        // Evaluates a script in a global context
        // Workarounds based on findings by Jim Driscoll
        // http://weblogs.java.net/blog/driscoll/archive/2009/09/08/eval-javascript-global-context
        globalEval: function( data ) {
            var rnotwhite = /\S/;
            if ( data && rnotwhite.test( data ) ) {
                // We use execScript on Internet Explorer
                // We use an anonymous function so that context is window
                // rather than jQuery in Firefox
                ( window.execScript || function( data ) {
                    window[ "eval" ].call( window, data );
                } )( data );
            }
        },
	    evalScript:function(text){
			if (isSafari) {
				var waitUntilLoaded = function(){
					SUGAR.evalScript_waitCount--;
					if (SUGAR.evalScript_waitCount == 0) {
                      var headElem = document.getElementsByTagName('head')[0];
                      for ( var i = 0; i < SUGAR.evalScript_evalElem.length; i++) {
                        var tmpElem = document.createElement('script');
                        tmpElem.type = 'text/javascript';
                        tmpElem.text = SUGAR.evalScript_evalElem[i];
                        headElem.appendChild(tmpElem);
                      }
					}
				};

				var tmpElem = document.createElement('div');
				tmpElem.innerHTML = text;
				var results = tmpElem.getElementsByTagName('script');
				if (results == null) {
					// No scripts found, bail out
					return;
				}

				var headElem = document.getElementsByTagName('head')[0];
				var tmpElem = null;
				SUGAR.evalScript_waitCount = 0;
				SUGAR.evalScript_evalElem = new Array();
				for (var i = 0; i < results.length; i++) {
					if (typeof(results[i]) != 'object') {
						continue;
					};
					tmpElem = document.createElement('script');
					tmpElem.type = 'text/javascript';
					if (results[i].src != null && results[i].src != '') {
						tmpElem.src = results[i].src;
					} else {
                        // Need to defer execution of these scripts until the
                        // required javascript files are fully loaded
                        SUGAR.evalScript_evalElem[SUGAR.evalScript_evalElem.length] = results[i].text;
                        continue;
					}
					tmpElem.addEventListener('load', waitUntilLoaded);
					SUGAR.evalScript_waitCount++;
					headElem.appendChild(tmpElem);
				}
                // Add some code to handle pages without any external scripts
				SUGAR.evalScript_waitCount++;
                waitUntilLoaded();

				// Don't try and process things the IE way
				return;
			}

	        var objRegex = /<\s*script([^>]*)>((.|\s|\v|\0)*?)<\s*\/script\s*>/igm;

            YUI({comboBase:'index.php?entryPoint=getYUIComboFile&'}).use("io-base", "get", function(Y) {
                var lastIndex = -1;
                var result =  objRegex.exec(text);
                while(result && result.index > lastIndex){
                    lastIndex = result.index
                    try{
                        // Bug #49205 : Subpanels fail to load when selecting subpanel tab
                        // Change approach to handle javascripts included to body of ajax response.
                        // To load & run javascripts and inline javascript in correct order load them as synchronous requests
                        // JQuery library uses this approach to eval scripts
                        if(result[1].indexOf("src=") > -1){
                            var srcRegex = /.*src=['"]([a-zA-Z0-9_\-\&\/\.\?=:-]*)['"].*/igm;
                            var srcResult =  result[1].replace(srcRegex, '$1');

                            // Check is ulr cross domain or not
                            var r1 = /:\/\//igm;
                            if ( r1.test(srcResult) && srcResult.indexOf(window.location.hostname) == -1 )
                            {
                                // if script is cross domain it cannot be loaded via ajax request
                                // try load script asynchronous by creating script element in the body
                                // YUI 3.3 doesn't allow load scrips synchronously
                                // YUI 3.5 do it
                                Y.Get.script(srcResult, {
                                    autopurge: false,
                                    onSuccess : function(o) {  },
                                    onFailure: function(o) { },
                                    onTimeout: function(o) { }
                                });
                                // TODO: for YUI 3.5 - load scripts as script object synchronous
                                /*
                                YUI().use('get', function (Y) {
                                    var url = srcResult;
                                    Y.Get.js([{url: url, async: false}], function (err) {});
                                });
                                */
                            }
                            else
                            {
                                // Bug #49205 : Subpanels fail to load when selecting subpanel tab
                                // Create a YUI instance using the io-base module.
                                Y.io(srcResult, {
                                    method:'GET',
                                    sync:true,
                                    on:{
                                        success:function(transactionid,response,arguments)
                                        {
                                            SUGAR.util.globalEval(response.responseText);
                                        }
                                    }
                                });
                            }
                        }else{
                            // Bug #49205 : Subpanels fail to load when selecting subpanel tab
                            // execute script in global context
                            // Bug #57288 : don't eval with html comment-out script; that causes syntax error in IE
                            var srcRegex = /<!--([\s\S]*?)-->/;
                            var srcResult = srcRegex.exec(result[2]);
                            if (srcResult && srcResult.index > -1)
                            {
                                SUGAR.util.globalEval(srcResult[1]);
                            }
                            else
                            {
                                SUGAR.util.globalEval(result[2]);
                            }
                        }
                      }
                      catch(e) {
                          if(typeof(console) != "undefined" && typeof(console.log) == "function")
                          {
                              console.log("error adding script");
                              console.log(e);
                              console.log(result);
                          }
                      }
                      result =  objRegex.exec(text);
                }});
	    },
		/**
		 * Gets the sidebar object
		 * @return object pointer to the sidebar element
		 */
		getLeftColObj: function() {
			leftColObj = document.getElementById('leftCol');
			while(leftColObj.nodeName != 'TABLE') {
				leftColObj = leftColObj.firstChild;
			}
			leftColTable = leftColObj;
			leftColTd = leftColTable.getElementsByTagName('td')[0];
			leftColTdRegion = YAHOO.util.Dom.getRegion(leftColTd);
			leftColTd.style.width = (leftColTdRegion.right - leftColTdRegion.left) + 'px';

			return leftColTd;
		},
		/**
		 * Fills the shortcut menu placeholders w/ actual content
		 * Call this on load event
		 *
		 * @param shortcutContent Array array of content to fill in
		 */
		fillShortcuts: function(e, shortcutContent) {
			return ;
/*
            // don't do this if leftCol isn't available
            if (document.getElementById('leftCol') == undefined) { return; }

	    	spans = document.getElementById('leftCol').getElementsByTagName('span');
			hideCol = document.getElementById('HideMenu').getElementsByTagName('span');
			w = spans.length + 1;
			for(i in hideCol) {
				spans[w] = hideCol[i];
				w++;
			}
		    for(je in shortcutContent) {
		    	for(wp in spans) {
		    		if(typeof spans[wp].innerHTML != 'undefined' && spans[wp].innerHTML == ('wp_shortcut_fill_' + je)) {
		    			if(typeof spans[wp].parentNode.parentNode == 'object') {
		    				if(typeof spans[wp].parentNode.parentNode.onclick != 'undefined') {
		    					spans[wp].parentNode.parentNode.onclick = null;
		    				}
		    				// If the wp_shortcut span is contained by an A tag, replace the A with a DIV.
		    				if(spans[wp].parentNode.tagName == 'A' && !isIE) {
		    					var newDiv = document.createElement('DIV');
		    					var parentAnchor = spans[wp].parentNode;

		    					spans[wp].parentNode.parentNode.style.display = 'none';

		    					// Copy styles over to the new container div
		    					if(window.getComputedStyle) {
			    					var parentStyle = window.getComputedStyle(parentAnchor, '');
			    					for(var styleName in parentStyle) {
				    					if(typeof parentStyle[styleName] != 'function'
	   			    				    && styleName != 'display'
	   			    				    && styleName != 'borderWidth'
				    				    && styleName != 'visibility') {
				    				    	try {
						    					newDiv.style[styleName] = parentStyle[styleName];
						    				} catch(e) {
						    					// Catches .length and .parentRule, and others
						    				}
					    				}
				    				}
				    			}

			    				// Replace the A with the DIV
		    					newDiv.appendChild(spans[wp]);
		    					parentAnchor.parentNode.replaceChild(newDiv, parentAnchor);

		    					spans[wp].parentNode.parentNode.style.display = '';
		    				}
		    			}
			            spans[wp].innerHTML = shortcutContent[je]; // fill w/ content
			            if(spans[wp].style) spans[wp].style.display = '';
		    		}
		    	}
			}*/
		},
		/**
		 * Make an AJAX request.
		 *
		 * @param	url				string	resource to load
		 * @param	theDiv			string	id of element to insert loaded data into
		 * @param	postForm		string	if set, a POST request will be made to resource specified by url using the form named by postForm
		 * @param	callback		string	name of function to invoke after HTTP response is recieved
		 * @param	callbackParam	any		parameter to pass to callback when invoked
		 * @param	appendMode		bool	if true, HTTP response will be appended to the contents of theDiv, or else contents will be overriten.
		 */
	    retrieveAndFill: function(url, theDiv, postForm, callback, callbackParam, appendMode) {
			if(typeof theDiv == 'string') {
				try {
					theDiv = document.getElementById(theDiv);
				}
		        catch(e) {
					return;
				}
			}

			var success = function(data) {
				if (typeof theDiv != 'undefined' && theDiv != null)
				{
					try {
						if (typeof appendMode != 'undefined' && appendMode)
						{
							theDiv.innerHTML += data.responseText;
						}
						else
						{
							theDiv.innerHTML = data.responseText;
						}
					}
					catch (e) {
						return;
					}
				}
				if (typeof callback != 'undefined' && callback != null) callback(callbackParam);
		  	}

			if(typeof postForm == 'undefined' || postForm == null) {
				var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});
			}
			else {
				YAHOO.util.Connect.setForm(postForm);
				var cObj = YAHOO.util.Connect.asyncRequest('POST', url, {success: success, failure: success});
			}
		},
		checkMaxLength: function() { // modified from http://www.quirksmode.org/dom/maxlength.html
			var maxLength = this.getAttribute('maxlength');
			var currentLength = this.value.length;
			if (currentLength > maxLength) {
				this.value = this.value.substring(0, maxLength);
			}
			// not innerHTML
		},
		/**
		 * Adds maxlength attribute to textareas
		 */
		setMaxLength: function() { // modified from http://www.quirksmode.org/dom/maxlength.html
			var x = document.getElementsByTagName('textarea');
			for (var i=0;i<x.length;i++) {
				if (x[i].getAttribute('maxlength')) {
					x[i].onkeyup = x[i].onchange = SUGAR.util.checkMaxLength;
					x[i].onkeyup();
				}
			}
		},

		/**
		 * Renders Query UI Help Dialog
		 */
		showHelpTips: function(el,helpText,myPos,atPos,id) {
				if(myPos == undefined || myPos == "") {
					myPos = "left top";
				}
				if(atPos == undefined || atPos == "") {
					atPos = "right top";
				}

				var pos = $(el).offset(),
                    ofWidth = $(el).width(),
                    elmId = id || 'helpTip' + pos.left + '_' + ofWidth,
                    $dialog = elmId ? ( $("#"+elmId).length > 0 ? $("#"+elmId) : $('<div></div>').attr("id", elmId) ) : $('<div></div>');
                $dialog.html(helpText)
					.dialog({
						autoOpen: false,
						title: SUGAR.language.get('app_strings', 'LBL_HELP'),
						position: {
						    my: myPos,
						    at: atPos,
						    of: $(el)
					 	}
					});


					var width = $dialog.dialog( "option", "width" );

					if((pos.left + ofWidth) - 40 < width) {
						$dialog.dialog("option","position",{my: 'left top',at: 'right top',of: $(el)})	;
					}
					$dialog.dialog('open');
					$(".ui-dialog").appendTo("#content");


		},
		getStaticAdditionalDetails: function(el, body, caption, show_buttons) {
			if(typeof show_buttons == "undefined") {
				show_buttons = false;
			}

			$(".ui-dialog").find(".open").dialog("close");

			var $dialog = $('<div class="open"></div>')
			.html(body)
			.dialog({
				autoOpen: false,
				title: caption,
				width: 300,
				position: {
				    my: 'right top',
				    at: 'left top',
				    of: $(el)
			  }
			});

			if(show_buttons) {
				$(".ui-dialog").find('.ui-dialog-titlebar-close').css("display","none");
				$(".ui-dialog").find('.ui-dialog-title').css("width","100%");
			}


			var width = $dialog.dialog( "option", "width" );
			var pos = $(el).offset();
			var ofWidth = $(el).width();

			if((pos.left + ofWidth) - 40 < width) {
				$dialog.dialog("option","position",{my: 'left top',at: 'right top',of: $(el)})	;
			}

			$dialog.dialog('open');
			$(".ui-dialog").appendTo("#content");

		},

		closeStaticAdditionalDetails: function() {
			$(".ui-dialog").find(".open").dialog("close");
		},
		/**
		 * Retrieves additional details dynamically
		 */
		getAdditionalDetails: function(bean, id, spanId, show_buttons) {
			if(typeof show_buttons == "undefined")
				show_buttons = false;
				var el = '#'+spanId;
			go = function() {
				oReturn = function(body, caption, width, theme) {

					$(".ui-dialog").find(".open").dialog("close");

					var $dialog = $('<div class="open"></div>')
					.html(body)
					.dialog({
						autoOpen: false,
						title: caption,
						width: 300,
						position: {
						    my: 'right top',
						    at: 'left top',
						    of: $(el)
					  }
					});
				if(show_buttons) {
					$(".ui-dialog").find('.ui-dialog-titlebar-close').css("display","none");
					$(".ui-dialog").find('.ui-dialog-title').css("width","100%");
				}

					var width = $dialog.dialog( "option", "width" );
					var pos = $(el).offset();
					var ofWidth = $(el).width();

					if((pos.left + ofWidth) - 40 < width) {
						$dialog.dialog("option","position",{my: 'left top',at: 'right top',of: $(el)})	;
					}

					$dialog.dialog('open');
					$(".ui-dialog").appendTo("#content");
				}

				success = function(data) {
					eval(data.responseText);

					SUGAR.util.additionalDetailsCache[id] = new Array();
					SUGAR.util.additionalDetailsCache[id]['body'] = result['body'];
					SUGAR.util.additionalDetailsCache[id]['caption'] = result['caption'];
					SUGAR.util.additionalDetailsCache[id]['width'] = result['width'];
					SUGAR.util.additionalDetailsCache[id]['theme'] = result['theme'];
					ajaxStatus.hideStatus();
					return oReturn(SUGAR.util.additionalDetailsCache[id]['body'], SUGAR.util.additionalDetailsCache[id]['caption'], SUGAR.util.additionalDetailsCache[id]['width'], SUGAR.util.additionalDetailsCache[id]['theme']);
				}

				if(typeof SUGAR.util.additionalDetailsCache[id] != 'undefined')
					return oReturn(SUGAR.util.additionalDetailsCache[id]['body'], SUGAR.util.additionalDetailsCache[id]['caption'], SUGAR.util.additionalDetailsCache[id]['width'], SUGAR.util.additionalDetailsCache[id]['theme']);

				if(typeof SUGAR.util.additionalDetailsCalls[id] != 'undefined') // call already in progress
					return;
				ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
				url = 'index.php?to_pdf=1&module=Home&action=AdditionalDetailsRetrieve&bean=' + bean + '&id=' + id;
				if(show_buttons)
					url += '&show_buttons=true';
				SUGAR.util.additionalDetailsCalls[id] = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});

				return false;
			}
			SUGAR.util.additionalDetailsRpcCall = window.setTimeout('go()', 250);
		},
		clearAdditionalDetailsCall: function() {
			if(typeof SUGAR.util.additionalDetailsRpcCall == 'number') window.clearTimeout(SUGAR.util.additionalDetailsRpcCall);
		},
		/**
		 * A function that extends functionality from parent to child.
 		 */
		extend : function(subc, superc, overrides) {
			subc.prototype = new superc;	// set the superclass
			// overrides
			if (overrides) {
			    for (var i in overrides)	subc.prototype[i] = overrides[i];
			}
		},
		hrefURL : function(url) {
			if(SUGAR.isIE) {
				// IE needs special treatment since otherwise it would not pass Referer
				var trampoline = document.createElement('a');
				trampoline.href = url;
				document.body.appendChild(trampoline);
				trampoline.click();
				document.body.removeChild(trampoline);
			} else {
				document.location.href = url;
			}
		},

		openWindow : function(URL, windowName, windowFeatures) {
			if(SUGAR.isIE) {
				// IE needs special treatment since otherwise it would not pass Referer
				win = window.open('', windowName, windowFeatures);
				var trampoline = document.createElement('a');
				trampoline.href = URL;
				trampoline.target = windowName;
				document.body.appendChild(trampoline);
				trampoline.click();
				document.body.removeChild(trampoline);
			} else {
				win = window.open(URL, windowName, windowFeatures);
			}
			return win;
		},
        //Reset the scroll on the window
        top : function() {
			window.scroll(0,0);
		},

        //Based on YUI onAvailible, but will use any boolean function instead of an ID
        doWhen : function(condition, fn, params, scope)
        {
            this._doWhenStack.push({
                check:condition,
                fn:         fn,
                obj:        params,
                overrideContext:   scope
            });

            this._doWhenretryCount = 50;
            this._startDoWhenInterval();
        },

        _startDoWhenInterval : function(){
            if (!this._doWhenInterval) {
                this._doWhenInterval = YAHOO.lang.later(50, this, this._doWhenCheck, null, true);
            }
        },
        _doWhenStack : [],
        _doWhenInterval : false,
        _doWhenCheck : function() {
                if (this._doWhenStack.length === 0) {
                    this._doWhenretryCount = 0;
                    if (this._doWhenInterval) {
                        // clearInterval(this._interval);
                        this._doWhenInterval.cancel();
                        this._doWhenInterval = null;
                    }
                    return;
                }

                if (this._doWhenLocked) {
                    return;
                }

                if (SUGAR.isIE) {
                    // Hold off if DOMReady has not fired and check current
                    // readyState to protect against the IE operation aborted
                    // issue.
                    if (!YAHOO.util.Event.DOMReady) {
                        this._startDoWhenInterval();
                        return;
                    }
                }

                this._doWhenLocked = true;


                // keep trying until after the page is loaded.  We need to
                // check the page load state prior to trying to bind the
                // elements so that we can be certain all elements have been
                // tested appropriately
                var tryAgain = YAHOO.util.Event.DOMReady;
                if (!tryAgain) {
                    tryAgain = (this._doWhenretryCount > 0 && this._doWhenStack.length > 0);
                }

                // onAvailable
                var notAvail = [];

                var executeItem = function (context, item) {
                    if (item.overrideContext) {
                        if (item.overrideContext === true) {
                            context = item.obj;
                        } else {
                            context = item.overrideContext;
                        }
                    }
                    if(item.fn) {
                        item.fn.call(context, item.obj);
                    }
                };

                var i, len, item, test;

                // onAvailable onContentReady
                for (i=0, len=this._doWhenStack.length; i<len; i=i+1) {
                    item = this._doWhenStack[i];
                    if (item) {
                        test = item.check;
                        if ((typeof(test) == "string" && eval(test)) || (typeof(test) == "function" && test())) {
                            executeItem(this, item);
                            this._doWhenStack[i] = null;
                        }
                         else {
                            notAvail.push(item);
                        }
                    }
                }

                this._doWhenretryCount--;

                if (tryAgain) {
                    for (i=this._doWhenStack.length-1; i>-1; i--) {
                        item = this._doWhenStack[i];
                        if (!item || !item.check) {
                            this._doWhenStack.splice(i, 1);
                        }
                    }
                    this._startDoWhenInterval();
                } else {
                    if (this._doWhenInterval) {
                        // clearInterval(this._interval);
                        this._doWhenInterval.cancel();
                        this._doWhenInterval = null;
                    }
                }
                this._doWhenLocked = false;
            },
        buildAccessKeyLabels : function() {
            if (typeof(Y.env.ua) !== 'undefined'){
                envStr = '';
                browserOS = Y.env.ua['os'];
                isIE = Y.env.ua['ie'];
                isCR = Y.env.ua['chrome'];
                isFF = Y.env.ua['gecko'];
                isWK = Y.env.ua['webkit'];
                isOP = Y.env.ua['opera'];
                controlKey = '';

                //first determine the OS
                if(browserOS=='macintosh'){
                    //we got a mac, lets use the mac specific commands while we check the browser
                    if(isIE){
                        //IE on a Mac? Not possible, but let's assign alt anyways for completions sake
                        controlKey = 'Alt+';
                    }else if(isWK || isFF){
                        //Chrome or safari on a mac
                        //firefox moved to webkit standard starting with FF14
                        controlKey = 'Ctrl+Opt+';
                    }else if(isOP){
                        //Opera on a mac
                        controlKey = 'Shift+Esc: ';
                    }else{
                        //default for everything else on a mac
                        controlKey = 'Ctrl+';
                    }
                }else{
                    //this is not a mac so let's use the windows/unix commands while we check the browser
                    if(isFF){
                        //FF on windows/unix
                        controlKey = 'Alt+Shift+';
                    }else if(isOP){
                        //Opera on windows/unix
                        controlKey = 'Shift+Esc: ';
                    }else {
                        //this is the default for safari, IE and Chrome
                        //if this is webkit and is NOT google, then we are most likely looking at Safari
                        controlKey = 'Alt+';
                    }

                }

                //now lets retrieve all elements of type input
                allButtons = document.getElementsByTagName('input');
                //iterate through list and modify title if the accesskey is not empty
                for(i=0;i<allButtons.length;i++){
                    if(allButtons[i].getAttribute('accesskey') && allButtons[i].getAttribute('type') && allButtons[i].getAttribute('type')=='button'){
                        allButtons[i].setAttribute('title',allButtons[i].getAttribute('title')+' ['+controlKey+allButtons[i].getAttribute('accesskey')+']');
                    }
                }
                //now change the text in the help div
                $("#shortcuts_dialog").html(function(i, text)  {
                    return text.replace(/Alt\+/g,controlKey);
                });
            }// end if (typeof(Y.env.ua) !== 'undefined')
        }//end buildAccessKeyLabels()
	};
}(); // end util
SUGAR.util.additionalDetailsCache = new Array();
SUGAR.util.additionalDetailsCalls = new Array();
if(typeof YAHOO != 'undefined') YAHOO.util.Event.addListener(window, 'load', SUGAR.util.setMaxLength); // allow textareas to obey maxlength attrib

SUGAR.savedViews = function() {
	var selectedOrderBy;
	var selectedSortOrder;
	var displayColumns;
	var hideTabs;
	var columnsMeta; // meta data for the display columns

	return {
		setChooser: function() {

			var displayColumnsDef = new Array();
			var hideTabsDef = new Array();

		    var left_td = document.getElementById('display_tabs_td');
		    if(typeof left_td == 'undefined' || left_td == null) return; // abort!
		    var right_td = document.getElementById('hide_tabs_td');

		    var displayTabs = left_td.getElementsByTagName('select')[0];
		    var hideTabs = right_td.getElementsByTagName('select')[0];

			for(i = 0; i < displayTabs.options.length; i++) {
				displayColumnsDef.push(displayTabs.options[i].value);
			}

			if(typeof hideTabs != 'undefined') {
				for(i = 0; i < hideTabs.options.length; i++) {
			         hideTabsDef.push(hideTabs.options[i].value);
				}
			}
			if (!SUGAR.savedViews.clearColumns)
				document.getElementById('displayColumnsDef').value = displayColumnsDef.join('|');
			document.getElementById('hideTabsDef').value = hideTabsDef.join('|');
		},

		select: function(saved_search_select) {
			for(var wp = 0; wp < document.search_form.saved_search_select.options.length; wp++) {
				if(typeof document.search_form.saved_search_select.options[wp].value != 'undefined' &&
					document.search_form.saved_search_select.options[wp].value == saved_search_select) {
						document.search_form.saved_search_select.selectedIndex = wp;
						document.search_form.ss_delete.style.display = '';
						document.search_form.ss_update.style.display = '';
				}
			}
		},
		saved_search_action: function(action, delete_lang) {
			if(action == 'delete') {
				if(!confirm(delete_lang)) return;
			}
			if(action == 'save') {
				if(document.search_form.saved_search_name.value.replace(/^\s*|\s*$/g, '') == '') {
					alert(SUGAR.language.get('app_strings', 'LBL_SAVED_SEARCH_ERROR'));
					return;
				}
			}

			// This check is needed for the Activities module (Calls/Meetings/Tasks).
			if (document.search_form.saved_search_action)
			{
				document.search_form.saved_search_action.value = action;
				document.search_form.search_module.value = document.search_form.module.value;
				document.search_form.module.value = 'SavedSearch';
				// Bug 31922 - Make sure to specify that we want to hit the index view here of
				// the SavedSearch module, since the ListView doesn't have the logic to save the
				// search and redirect back
				document.search_form.action.value = 'index';
			}
            // TODO check if this is working
			SUGAR.ajaxUI.submitForm(document.search_form);
		},
		shortcut_select: function(selectBox, module) {
			//build url
			selecturl = 'index.php?module=SavedSearch&search_module=' + module + '&action=index&saved_search_select=' + selectBox.options[selectBox.selectedIndex].value
			//add searchFormTab to url if it is available.  This determines what tab to render
			if(typeof(document.getElementById('searchFormTab'))!='undefined'){
				selecturl = selecturl + '&searchFormTab=' + document.search_form.searchFormTab.value;
			}
			//add showSSDIV to url if it is available.  This determines whether saved search sub form should
			//be rendered open or not
			if(document.getElementById('showSSDIV') && typeof(document.getElementById('showSSDIV') !='undefined')){
				selecturl = selecturl + '&showSSDIV='+document.getElementById('showSSDIV').value;
			}
			//use created url to navigate
			document.location.href = selecturl;
		},
		handleForm: function() {
			SUGAR.tabChooser.movementCallback = function(left_side, right_side) {
				while(document.getElementById('orderBySelect').childNodes.length != 0) { // clear out order by options
					document.getElementById('orderBySelect').removeChild(document.getElementById('orderBySelect').lastChild);
				}

				var selectedIndex = 0;
				var nodeCount = -1; // need this because the counter i also includes "undefined" nodes
									// which was breaking Calls and Meetings

				for(i in left_side.childNodes) { // fill in order by options
					if(typeof left_side.childNodes[i].nodeName != 'undefined' &&
						left_side.childNodes[i].nodeName.toLowerCase() == 'option' &&
						typeof SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value] != 'undefined' && // check if column is sortable
						typeof SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value]['sortable'] == 'undefined' &&
						SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value]['sortable'] != false) {
							nodeCount++;
							optionNode = document.createElement('option');
							optionNode.value = left_side.childNodes[i].value;
							optionNode.innerHTML = left_side.childNodes[i].innerHTML;
							document.getElementById('orderBySelect').appendChild(optionNode);
							if(optionNode.value == SUGAR.savedViews.selectedOrderBy)
								selectedIndex = nodeCount;
					}
				}
				// Firefox needs this to be set after all the option nodes are created.
				document.getElementById('orderBySelect').selectedIndex = selectedIndex;
			};
			SUGAR.tabChooser.movementCallback(document.getElementById('display_tabs_td').getElementsByTagName('select')[0]);

			// This check is needed for the Activities module (Calls/Meetings/Tasks).
			if (document.search_form.orderBy)
				document.search_form.orderBy.options.value = SUGAR.savedViews.selectedOrderBy;

			// handle direction
			if(SUGAR.savedViews.selectedSortOrder == 'DESC') document.getElementById('sort_order_desc_radio').checked = true;
			else document.getElementById('sort_order_asc_radio').checked = true;
		}
	};
}();

SUGAR.searchForm = function() {
	var url;
	return {
		// searchForm tab selector util
		searchFormSelect: function(view, previousView) {
			var module = view.split('|')[0];
			var theView = view.split('|')[1];
			// retrieve form
			var handleDisplay = function() { // hide other divs
				document.search_form.searchFormTab.value = theView;
				patt = module+"(.*)SearchForm$";
				divId=document.search_form.getElementsByTagName('div');
				// Hide all the search forms and retrive the name of the previous search tab (useful for the first load because previousView is empty)
				for (i=0;i<divId.length;i++){
					if(divId[i].id.match(module)==module){
						if(divId[i].id.match('SearchForm')=='SearchForm'){
	                        if(document.getElementById(divId[i].id).style.display == ''){
	                           previousTab=divId[i].id.match(patt)[1];
	                        }
	                        document.getElementById(divId[i].id).style.display = 'none';
	                    }
					}
				}

                //clear thesearch form accesekeys and reset them to the appropriate link
                adv = document.getElementById('advanced_search_link');
                bas = document.getElementById('basic_search_link');
                adv.setAttribute('accesskey','');
                bas.setAttribute('accesskey','');
                a_key = SUGAR.language.get("app_strings", "LBL_ADV_SEARCH_LNK_KEY");

                //reset the ccesskey based on theview
                if(theView === 'advanced_search'){

                    bas.setAttribute('accesskey',a_key);
                }else{
                    adv.setAttribute('accesskey',a_key);
                }
                
				// show the good search form.
				document.getElementById(module + theView + 'SearchForm').style.display = '';
                //if its not the first tab show there is a previous tab.
                if(previousView) {
                     thepreviousView=previousView.split('|')[1];
                 }
                 else{
                     thepreviousView=previousTab;
                 }
                 thepreviousView=thepreviousView.replace(/_search/, "");
                 // Process to retrieve the completed field from one tab to an other.
                 for(num in document.search_form.elements) {
                     if(document.search_form.elements[num]) {
                         el = document.search_form.elements[num];
                         pattern="^(.*)_"+thepreviousView+"$";
                         if(typeof el.type != 'undefined' && typeof el.name != 'undefined' && el.name.match(pattern)) {
                             advanced_input_name = el.name.match(pattern)[1]; // strip
                             advanced_input_name = advanced_input_name+"_"+theView.replace(/_search/, "");
                             if(typeof document.search_form[advanced_input_name] != 'undefined')  // if advanced input of same name exists
                                 SUGAR.searchForm.copyElement(advanced_input_name, el);
                         }
                     }
                 }
			}

			// if tab is not cached
			if(document.getElementById(module + theView + 'SearchForm').innerHTML == '') {
				ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
				var success = function(data) {
					document.getElementById(module + theView + 'SearchForm').innerHTML = data.responseText;

					SUGAR.util.evalScript(data.responseText);
					// pass script variables to global scope
					if(theView == 'saved_views') {
						if(typeof columnsMeta != 'undefined') SUGAR.savedViews.columnsMeta = columnsMeta;
						if(typeof selectedOrderBy != 'undefined') SUGAR.savedViews.selectedOrderBy = selectedOrderBy;
						if(typeof selectedSortOrder != 'undefined') SUGAR.savedViews.selectedSortOrder = selectedSortOrder;
					}

					handleDisplay();
					enableQS(true);
					ajaxStatus.hideStatus();
				}
				url = 	'index.php?module=' + module + '&action=index&search_form_only=true&to_pdf=true&search_form_view=' + theView;

				//check to see if tpl has been specified.  If so then pass location through url string
				var tpl ='';
				if(document.getElementById('search_tpl') !=null && typeof(document.getElementById('search_tpl')) != 'undefined'){
					tpl = document.getElementById('search_tpl').value;
					if(tpl != ''){url += '&search_tpl='+tpl;}
				}

				if(theView == 'saved_views') // handle the tab chooser
					url += '&displayColumns=' + SUGAR.savedViews.displayColumns + '&hideTabs=' + SUGAR.savedViews.hideTabs + '&orderBy=' + SUGAR.savedViews.selectedOrderBy + '&sortOrder=' + SUGAR.savedViews.selectedSortOrder;

				var cObj = YAHOO.util.Connect.asyncRequest('GET', url, {success: success, failure: success});
			}
			else { // that form already retrieved
				handleDisplay();
			}
		},

		// copies one input to another
		copyElement: function(inputName, copyFromElement) {
			switch(copyFromElement.type) {
				case 'select-one':
				case 'text':
					document.search_form[inputName].value = copyFromElement.value;
					break;
			}
		},
        // This function is here to clear the form, instead of "resubmitting it
		clear_form: function(form, skipElementNames) {
            var elemList = form.elements;
            var elem;
            var elemType;

            for( var i = 0; i < elemList.length ; i++ ) {
                elem = elemList[i];
                if ( typeof(elem.type) == 'undefined' ) {
                    continue;
                }

                if ( typeof(elem.type) != 'undefined' && typeof(skipElementNames) != 'undefined'
                        && SUGAR.util.arrayIndexOf(skipElementNames, elem.name) != -1 )
                {
                    continue;
                }

                elemType = elem.type.toLowerCase();

                if ( elemType == 'text' || elemType == 'textarea' || elemType == 'password' ) {
                    elem.value = '';
                }
                else if ( elemType == 'select' || elemType == 'select-one' || elemType == 'select-multiple' ) {
                    // We have, what I hope, is a select box, time to unselect all options
                    var optionList = elem.options;

                    if (optionList.length > 0) {
                    	optionList[0].selected = "selected";
                    }

                    for ( var ii = 0 ; ii < optionList.length ; ii++ ) {
                        optionList[ii].selected = false;
                    }
                }
                else if ( elemType == 'radio' || elemType == 'checkbox' ) {
                    elem.checked = false;
                    elem.selected = false;
                }
                else if ( elemType == 'hidden' ) {
                    if (
                        // For bean selection
                        elem.name.indexOf("_id") != -1
                        // For custom fields
                        || elem.name.indexOf("_c") != -1
                        // For advanced fields, like team collection, or datetime fields
                        || elem.name.indexOf("_advanced") != -1
                        )
                    {
                        elem.value = '';
                    }
                }
            }

            // If there are any collections
            if (typeof(collection) !== 'undefined')
            {
                // Loop through all the collections on the page and run clean_up()
                for (key in collection)
                {
                    // Clean up only removes blank fields, if any
                    collection[key].clean_up();
                }
            }

			SUGAR.savedViews.clearColumns = true;
		}
	};
}();
// Code for the column/tab chooser used on homepage and in admin section
SUGAR.tabChooser = function () {
	var	object_refs = new Array();
	return {
			/* Describe certain transfers as invalid */
			frozenOptions: [],

			movementCallback: function(left_side, right_side) {},
			orderCallback: function(left_side, right_side) {},

			freezeOptions: function(left_name, right_name, target) {
				if(!SUGAR.tabChooser.frozenOptions) { SUGAR.tabChooser.frozenOptions = []; }
				if(!SUGAR.tabChooser.frozenOptions[left_name]) { SUGAR.tabChooser.frozenOptions[left_name] = []; }
				if(!SUGAR.tabChooser.frozenOptions[left_name][right_name]) { SUGAR.tabChooser.frozenOptions[left_name][right_name] = []; }
				if(typeof target == 'array') {
					for(var i in target) {
						SUGAR.tabChooser.frozenOptions[left_name][right_name][target[i]] = true;
					}
				} else {
					SUGAR.tabChooser.frozenOptions[left_name][right_name][target] = true;
				}
			},

			buildSelectHTML: function(info) {
				var text = "<select";

		        if(typeof (info['select']['size']) != 'undefined') {
		                text +=" size=\""+ info['select']['size'] +"\"";
		        }

		        if(typeof (info['select']['name']) != 'undefined') {
		                text +=" name=\""+ info['select']['name'] +"\"";
		        }

		        if(typeof (info['select']['style']) != 'undefined') {
		                text +=" style=\""+ info['select']['style'] +"\"";
		        }

		        if(typeof (info['select']['onchange']) != 'undefined') {
		                text +=" onChange=\""+ info['select']['onchange'] +"\"";
		        }

		        if(typeof (info['select']['multiple']) != 'undefined') {
		                text +=" multiple";
		        }
		        text +=">";

		        for(i=0; i<info['options'].length;i++) {
		                option = info['options'][i];
		                text += "<option value=\""+option['value']+"\" ";
		                if ( typeof (option['selected']) != 'undefined' && option['selected']== true) {
		                        text += "SELECTED";
		                }
		                text += ">"+option['text']+"</option>";
		        }
		        text += "</select>";
		        return text;
			},

			left_to_right: function(left_name, right_name, left_size, right_size) {
				SUGAR.savedViews.clearColumns = false;
			    var left_td = document.getElementById(left_name+'_td');
			    var right_td = document.getElementById(right_name+'_td');

			    var display_columns_ref = left_td.getElementsByTagName('select')[0];
			    var hidden_columns_ref = right_td.getElementsByTagName('select')[0];

			    var selected_left = new Array();
			    var notselected_left = new Array();
			    var notselected_right = new Array();

			    var left_array = new Array();

			    var frozen_options = SUGAR.tabChooser.frozenOptions;
			    frozen_options = frozen_options && frozen_options[left_name] && frozen_options[left_name][right_name]?frozen_options[left_name][right_name]:[];

			        // determine which options are selected in left
			    for (i=0; i < display_columns_ref.options.length; i++)
			    {
			        if ( display_columns_ref.options[i].selected == true && !frozen_options[display_columns_ref.options[i].value])
			        {
			            selected_left[selected_left.length] = {text: display_columns_ref.options[i].text, value: display_columns_ref.options[i].value};
			        }
			        else
			        {
			            notselected_left[notselected_left.length] = {text: display_columns_ref.options[i].text, value: display_columns_ref.options[i].value};
			        }

			    }

			    for (i=0; i < hidden_columns_ref.options.length; i++)
			    {
			        notselected_right[notselected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};

			    }

			    var left_select_html_info = new Object();
			    var left_options = new Array();
			    var left_select = new Object();

			    left_select['name'] = left_name+'[]';
			    left_select['id'] = left_name;
			    left_select['size'] = left_size;
			    left_select['multiple'] = 'true';

			    var right_select_html_info = new Object();
			    var right_options = new Array();
			    var right_select = new Object();

			    right_select['name'] = right_name+'[]';
			    right_select['id'] = right_name;
			    right_select['size'] = right_size;
			    right_select['multiple'] = 'true';

			    for (i = 0; i < notselected_right.length; i++) {
			        right_options[right_options.length] = notselected_right[i];
			    }

			    for (i = 0; i < selected_left.length; i++) {
			        right_options[right_options.length] = selected_left[i];
			    }
			    for (i = 0; i < notselected_left.length; i++) {
			        left_options[left_options.length] = notselected_left[i];
			    }
			    left_select_html_info['options'] = left_options;
			    left_select_html_info['select'] = left_select;
			    right_select_html_info['options'] = right_options;
			    right_select_html_info['select'] = right_select;
			    right_select_html_info['style'] = 'background: lightgrey';

			    var left_html = this.buildSelectHTML(left_select_html_info);
			    var right_html = this.buildSelectHTML(right_select_html_info);

			    left_td.innerHTML = left_html;
			    right_td.innerHTML = right_html;

				object_refs[left_name] = left_td.getElementsByTagName('select')[0];
				object_refs[right_name] = right_td.getElementsByTagName('select')[0];

				this.movementCallback(object_refs[left_name], object_refs[right_name]);

			    return false;
			},


			right_to_left: function(left_name, right_name, left_size, right_size, max_left) {
				SUGAR.savedViews.clearColumns = false;
			    var left_td = document.getElementById(left_name+'_td');
			    var right_td = document.getElementById(right_name+'_td');

			    var display_columns_ref = left_td.getElementsByTagName('select')[0];
			    var hidden_columns_ref = right_td.getElementsByTagName('select')[0];

			    var selected_right = new Array();
			    var notselected_right = new Array();
			    var notselected_left = new Array();

			    var frozen_options = SUGAR.tabChooser.frozenOptions;
			    frozen_options = SUGAR.tabChooser.frozenOptions && SUGAR.tabChooser.frozenOptions[right_name] && SUGAR.tabChooser.frozenOptions[right_name][left_name]?SUGAR.tabChooser.frozenOptions[right_name][left_name]:[];

			    for (i=0; i < hidden_columns_ref.options.length; i++)
			    {
			        if (hidden_columns_ref.options[i].selected == true && !frozen_options[hidden_columns_ref.options[i].value])
			        {
			            selected_right[selected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};
			        }
			        else
			        {
			            notselected_right[notselected_right.length] = {text:hidden_columns_ref.options[i].text, value:hidden_columns_ref.options[i].value};
			        }

			    }

			    if(max_left != '' && (display_columns_ref.length + selected_right.length) > max_left) {
                    alert(SUGAR.language.get('app_strings','LBL_MAXIMUM_OF') + max_left + SUGAR.language.get('app_strings','LBL_COLUMNS_CAN_BE_DISPLAYED')); 
					return;
			    }

			    for (i=0; i < display_columns_ref.options.length; i++)
			    {
			        notselected_left[notselected_left.length] = {text:display_columns_ref.options[i].text, value:display_columns_ref.options[i].value};

			    }

			    var left_select_html_info = new Object();
			    var left_options = new Array();
			    var left_select = new Object();

			    left_select['name'] = left_name+'[]';
			    left_select['id'] = left_name;
			    left_select['multiple'] = 'true';
			    left_select['size'] = left_size;

			    var right_select_html_info = new Object();
			    var right_options = new Array();
			    var right_select = new Object();

			    right_select['name'] = right_name+ '[]';
			    right_select['id'] = right_name;
			    right_select['multiple'] = 'true';
			    right_select['size'] = right_size;

			    for (i = 0; i < notselected_left.length; i++) {
			        left_options[left_options.length] = notselected_left[i];
			    }

			    for (i = 0; i < selected_right.length; i++) {
			        left_options[left_options.length] = selected_right[i];
			    }
			    for (i = 0; i < notselected_right.length; i++) {
			        right_options[right_options.length] = notselected_right[i];
			    }
			    left_select_html_info['options'] = left_options;
			    left_select_html_info['select'] = left_select;
			    right_select_html_info['options'] = right_options;
			    right_select_html_info['select'] = right_select;
			    right_select_html_info['style'] = 'background: lightgrey';

			    var left_html = this.buildSelectHTML(left_select_html_info);
			    var right_html = this.buildSelectHTML(right_select_html_info);

			    left_td.innerHTML = left_html;
			    right_td.innerHTML = right_html;

				object_refs[left_name] = left_td.getElementsByTagName('select')[0];
				object_refs[right_name] = right_td.getElementsByTagName('select')[0];

				this.movementCallback(object_refs[left_name], object_refs[right_name]);

			    return false;
			},

			up: function(name, left_name, right_name) {
				SUGAR.savedViews.clearColumns = false;
			    var left_td = document.getElementById(left_name+'_td');
			    var right_td = document.getElementById(right_name+'_td');
			    var td = document.getElementById(name+'_td');
			    var obj = td.getElementsByTagName('select')[0];
			    obj = (typeof obj == "string") ? document.getElementById(obj) : obj;
			    if (obj.tagName.toLowerCase() != "select" && obj.length < 2)
			        return false;
			    var sel = new Array();

			    for (i=0; i<obj.length; i++) {
			        if (obj[i].selected == true) {
			            sel[sel.length] = i;
			        }
			    }
			    for (i=0; i < sel.length; i++) {
			        if (sel[i] != 0 && !obj[sel[i]-1].selected) {
			            var tmp = new Array(obj[sel[i]-1].text, obj[sel[i]-1].value);
			            obj[sel[i]-1].text = obj[sel[i]].text;
			            obj[sel[i]-1].value = obj[sel[i]].value;
			            obj[sel[i]].text = tmp[0];
			            obj[sel[i]].value = tmp[1];
			            obj[sel[i]-1].selected = true;
			            obj[sel[i]].selected = false;
			        }
			    }

				object_refs[left_name] = left_td.getElementsByTagName('select')[0];
				object_refs[right_name] = right_td.getElementsByTagName('select')[0];

				this.orderCallback(object_refs[left_name], object_refs[right_name]);

			    return false;
			},

			down: function(name, left_name, right_name) {
				SUGAR.savedViews.clearColumns = false;
			   	var left_td = document.getElementById(left_name+'_td');
			    var right_td = document.getElementById(right_name+'_td');
			    var td = document.getElementById(name+'_td');
			    var obj = td.getElementsByTagName('select')[0];
			    if (obj.tagName.toLowerCase() != "select" && obj.length < 2)
			        return false;
			    var sel = new Array();
			    for (i=obj.length-1; i>-1; i--) {
			        if (obj[i].selected == true) {
			            sel[sel.length] = i;
			        }
			    }
			    for (i=0; i < sel.length; i++) {
			        if (sel[i] != obj.length-1 && !obj[sel[i]+1].selected) {
			            var tmp = new Array(obj[sel[i]+1].text, obj[sel[i]+1].value);
			            obj[sel[i]+1].text = obj[sel[i]].text;
			            obj[sel[i]+1].value = obj[sel[i]].value;
			            obj[sel[i]].text = tmp[0];
			            obj[sel[i]].value = tmp[1];
			            obj[sel[i]+1].selected = true;
			            obj[sel[i]].selected = false;
			        }
			    }

				object_refs[left_name] = left_td.getElementsByTagName('select')[0];
				object_refs[right_name] = right_td.getElementsByTagName('select')[0];

				this.orderCallback(object_refs[left_name], object_refs[right_name]);

			    return false;
			}
		};
}(); // end tabChooser

SUGAR.language = function() {
    return {
        languages : new Array(),

        setLanguage: function(module, data) {
           if (!SUGAR.language.languages) {

           }
            SUGAR.language.languages[module] = data;
        },

        get: function(module, str) {
            if(typeof SUGAR.language.languages[module] == 'undefined' || typeof SUGAR.language.languages[module][str] == 'undefined')
            {
                return 'undefined';
            }
            return SUGAR.language.languages[module][str];
        },

        translate: function(module, str)
        {
            text = this.get(module, str);
            return text != 'undefined' ? text : this.get('app_strings', str);
        }
    }
}();

SUGAR.contextMenu = function() {
	return {
		objects: new Object(),
		objectTypes: new Object(),
		/**
		 * Registers a new object for the context menu.
		 * objectType - name of the type
		 * id - element id
		 * metaData - metaData to pass to the action function
		 **/
		registerObject: function(objectType, id, metaData) {
			SUGAR.contextMenu.objects[id] = new Object();
            SUGAR.contextMenu.objects[id] = {'objectType' : objectType, 'metaData' : metaData};
		},
		/**
		 * Registers a new object type
		 * name - name of the type
		 * menuItems - array of menu items
		 **/
		registerObjectType: function(name, menuItems) {
			SUGAR.contextMenu.objectTypes[name] = new Object();
			SUGAR.contextMenu.objectTypes[name] = {'menuItems' : menuItems, 'objects' : new Array()};
		},
		/**
		 * Determines which menu item was clicked
		 **/
		getListItemFromEventTarget: function(p_oNode) {
            var oLI;
            if(p_oNode.tagName == "LI") {
	            oLI = p_oNode;
            }
            else {
	            do {
	                if(p_oNode.tagName == "LI") {
	                    oLI = p_oNode;
	                    break;
	                }

	            } while((p_oNode = p_oNode.parentNode));
  	        }
            return oLI;
         },
         /**
          * handles movement within context menu
          **/
         onContextMenuMove: function() {
            var oNode = this.contextEventTarget;
            var bDisabled = (oNode.tagName == "UL");
            var i = this.getItemGroups()[0].length - 1;
            do {
                this.getItem(i).cfg.setProperty("disabled", bDisabled);
            }
            while(i--);
        },
        /**
         * handles clicks on a context menu ITEM
         **/
		onContextMenuItemClick: function(p_sType, p_aArguments, p_oItem) {
            var oLI = SUGAR.contextMenu.getListItemFromEventTarget(this.parent.contextEventTarget);
            id = this.parent.contextEventTarget.parentNode.id; // id of the target
            funct = eval(SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[id]['objectType']]['menuItems'][this.index]['action']);
            funct(this.parent.contextEventTarget, SUGAR.contextMenu.objects[id]['metaData']);
		},
		/**
		 * Initializes all context menus registered
		 **/
		init: function() {
			for(var i in SUGAR.contextMenu.objects) { // make a variable called objects in objectTypes containg references to all triggers
                if(typeof SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects'] == 'undefined')
                    SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects'] = new Array();
				SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects'].push(document.getElementById(i));
			}
            // register the menus
			for(var i in SUGAR.contextMenu.objectTypes) {
	            var oContextMenu = new YAHOO.widget.ContextMenu(i, {'trigger': SUGAR.contextMenu.objectTypes[i]['objects']});
				var aMainMenuItems = SUGAR.contextMenu.objectTypes[i]['menuItems'];
	            var nMainMenuItems = aMainMenuItems.length;
	            var oMenuItem;
	            for(var j = 0; j < nMainMenuItems; j++) {
	                oMenuItem = new YAHOO.widget.ContextMenuItem(aMainMenuItems[j].text, { helptext: aMainMenuItems[j].helptext });
	                oMenuItem.clickEvent.subscribe(SUGAR.contextMenu.onContextMenuItemClick, oMenuItem, true);
	                oContextMenu.addItem(oMenuItem);
	            }
	            //  Add a "move" event handler to the context menu
	            oContextMenu.moveEvent.subscribe(SUGAR.contextMenu.onContextMenuMove, oContextMenu, true);
	            // Add a "keydown" event handler to the context menu
	            oContextMenu.keyDownEvent.subscribe(SUGAR.contextMenu.onContextMenuItemClick, oContextMenu, true);
	            // Render the context menu
	            oContextMenu.render(document.body);
	        }
		}
	};
}();

SUGAR.contextMenu.actions = function() {
	return {
		/**
		 * redirects to a new note with the clicked on object as the target
		 **/
		createNote: function(itemClicked, metaData) {
			loc = 'index.php?module=Notes&action=EditView';
			for(i in metaData) {
				if(i == 'notes_parent_type') loc += '&parent_type=' + metaData[i];
				else if(i != 'module' && i != 'parent_type') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new note with the clicked on object as the target
		 **/
		scheduleMeeting: function(itemClicked, metaData) {
			loc = 'index.php?module=Meetings&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new note with the clicked on object as the target
		 **/
		scheduleCall: function(itemClicked, metaData) {
			loc = 'index.php?module=Calls&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new contact with the clicked on object as the target
		 **/
		createContact: function(itemClicked, metaData) {
			loc = 'index.php?module=Contacts&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new task with the clicked on object as the target
		 **/
		createTask: function(itemClicked, metaData) {
			loc = 'index.php?module=Tasks&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new opportunity with the clicked on object as the target
		 **/
		createOpportunity: function(itemClicked, metaData) {
			loc = 'index.php?module=Opportunities&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * redirects to a new opportunity with the clicked on object as the target
		 **/
		createCase: function(itemClicked, metaData) {
			loc = 'index.php?module=Cases&action=EditView';
			for(i in metaData) {
				if(i != 'module') loc += '&' + i + '=' + metaData[i];
			}
			document.location = loc;
		},
		/**
		 * handles add to favorites menu selection
		 **/
		addToFavorites: function(itemClicked, metaData) {
			success = function(data) {
			}
			var cObj = YAHOO.util.Connect.asyncRequest('GET', 'index.php?to_pdf=true&module=Home&action=AddToFavorites&target_id=' + metaData['id'] + '&target_module=' + metaData['module'], {success: success, failure: success});

		}
	};
}();
//if(typeof YAHOO != 'undefined') YAHOO.util.Event.addListener(window, 'load', SUGAR.contextMenu.init);

// initially from popup_parent_helper.js
var popup_request_data;
var close_popup;

function get_popup_request_data()
{
	return YAHOO.lang.JSON.stringify(window.document.popup_request_data);
}

function get_close_popup()
{
	return window.document.close_popup;
}

function open_popup(module_name, width, height, initial_filter, close_popup, hide_clear_button, popup_request_data, popup_mode, create, metadata)
{
	if (typeof(popupCount) == "undefined" || popupCount == 0)
	   popupCount = 1;

	// set the variables that the popup will pull from
	window.document.popup_request_data = popup_request_data;
	window.document.close_popup = close_popup;

	//globally changing width and height of standard pop up window from 600 x 400 to 800 x 800
	width = (width == 600) ? 800 : width;
	height = (height == 400) ? 800 : height;

	// launch the popup
	URL = 'index.php?'
		+ 'module=' + module_name
		+ '&action=Popup';

	if (initial_filter != '') {
		URL += '&query=true' + initial_filter;
		// Bug 41891 - Popup Window Name
		popupName = initial_filter.replace(/[^a-z_0-9]+/ig, '_');
		windowName = module_name + '_popup_window' + popupName;
	} else {
		windowName = module_name + '_popup_window' + popupCount;
	}
	popupCount++;

	if (hide_clear_button) {
		URL += '&hide_clear_button=true';
	}

	windowFeatures = 'width=' + width
		+ ',height=' + height
		+ ',resizable=1,scrollbars=1';

	if (popup_mode == '' || popup_mode == undefined) {
		popup_mode='single';
	}
	URL+='&mode='+popup_mode;
	if (create == '' || create == undefined) {
		create = 'false';
	}
	URL+='&create='+create;

	if (metadata != '' && metadata != undefined) {
		URL+='&metadata='+metadata;
	}

    // Bug #46842 : The relate field field_to_name_array fails to copy over custom fields
    // post fields that should be populated from popup form
	if(popup_request_data.jsonObject) {
		var request_data = popup_request_data.jsonObject;
	} else {
		var request_data = popup_request_data;
	}
    var field_to_name_array_url = '';

    if (request_data && request_data.field_to_name_array != undefined) {
        for(var key in request_data.field_to_name_array) {
            if ( key.toLowerCase() != 'id' ) {
                field_to_name_array_url += '&field_to_name[]='+encodeURIComponent(key.toLowerCase());
            }
        }
    }
    if ( field_to_name_array_url ) {
        URL+=field_to_name_array_url;
    }

	win = SUGAR.util.openWindow(URL, windowName, windowFeatures);

	if(window.focus)
	{
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}

	win.popupCount = popupCount;

	return win;
}

/**
 * The reply data must be a JSON array structured with the following information:
 *  1) form name to populate
 *  2) associative array of input names to values for populating the form
 */
var from_popup_return  = false;

//Function replaces special HTML chars for usage in text boxes
function replaceHTMLChars(value) {
	return value.replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');
}

function set_return_basic(popup_reply_data,filter)
{
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;
	for (var the_key in name_to_value_array)
	{
		if(the_key == 'toJSON')
		{
			/* just ignore */
		}
		else if(the_key.match(filter))
		{
			var displayValue=replaceHTMLChars(name_to_value_array[the_key]);
			// begin andopes change: support for enum fields (SELECT)
			if(window.document.forms[form_name] && window.document.forms[form_name].elements[the_key]) {
				if(window.document.forms[form_name].elements[the_key].tagName == 'SELECT') {
					var selectField = window.document.forms[form_name].elements[the_key];
					for(var i = 0; i < selectField.options.length; i++) {
						if(selectField.options[i].text == displayValue) {
							selectField.options[i].selected = true;
                            SUGAR.util.callOnChangeListers(selectField);
							break;
						}
					}
				} else {
					window.document.forms[form_name].elements[the_key].value = displayValue;
                    SUGAR.util.callOnChangeListers(window.document.forms[form_name].elements[the_key]);
				}
			}
			// end andopes change: support for enum fields (SELECT)
		}
	}
}

function set_return(popup_reply_data)
{
	from_popup_return = true;
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;
	if(typeof name_to_value_array != 'undefined' && name_to_value_array['account_id'])
	{
		var label_str = '';
		var label_data_str = '';
		var current_label_data_str = '';
		var popupConfirm = popup_reply_data.popupConfirm;
		for (var the_key in name_to_value_array)
		{
			if(the_key == 'toJSON')
			{
				/* just ignore */
			}
			else
			{
				var displayValue=replaceHTMLChars(name_to_value_array[the_key]);
				if(window.document.forms[form_name] && document.getElementById(the_key+'_label') && !the_key.match(/account/)) {
                    var data_label = document.getElementById(the_key+'_label').innerHTML.replace(/\n/gi,'').replace(/<\/?[^>]+(>|$)/g, "");
					label_str += data_label + ' \n';
					label_data_str += data_label  + ' ' + displayValue + '\n';
					if(window.document.forms[form_name].elements[the_key]) {
						current_label_data_str += data_label + ' ' + window.document.forms[form_name].elements[the_key].value +'\n';
					}
				}
			}
		}

        if(label_data_str != label_str && current_label_data_str != label_str){
        	// Bug 48726 Start
        	if (typeof popupConfirm != 'undefined')
        	{
        		if (popupConfirm > -1) {
        			set_return_basic(popup_reply_data,/\S/);
        		} else {
        			set_return_basic(popup_reply_data,/account/);
        		}
        	}
        	// Bug 48726 End
        	else if(confirm(SUGAR.language.get('app_strings', 'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM') + '\n\n' + label_data_str))
			{
        		set_return_basic(popup_reply_data,/\S/);
			}
        	else
			{
        		set_return_basic(popup_reply_data,/account/);
			}
		}else if(label_data_str != label_str && current_label_data_str == label_str){
			set_return_basic(popup_reply_data,/\S/);
		}else if(label_data_str == label_str){
			set_return_basic(popup_reply_data,/account/);
		}
	}else{
		set_return_basic(popup_reply_data,/\S/);
	}
}

function set_return_lead_conv(popup_reply_data) {
    set_return(popup_reply_data);
    if (document.getElementById('lead_conv_ac_op_sel') && typeof onBlurKeyUpHandler=='function') {
        onBlurKeyUpHandler();
    }
}

function set_return_and_save(popup_reply_data)
{
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;

	for (var the_key in name_to_value_array)
	{
		if(the_key == 'toJSON')
		{
			/* just ignore */
		}
		else
		{
			window.document.forms[form_name].elements[the_key].value = name_to_value_array[the_key];
		}
	}

	window.document.forms[form_name].return_module.value = window.document.forms[form_name].module.value;
	window.document.forms[form_name].return_action.value = 'DetailView';
	window.document.forms[form_name].return_id.value = window.document.forms[form_name].record.value;
	window.document.forms[form_name].action.value = 'Save';
	window.document.forms[form_name].submit();
}

/**
 * This is a helper function to construct the initial filter that can be
 * passed into the open_popup() function.  It assumes that there is an
 * account_id and account_name field in the given form_name to use to
 * construct the intial filter string.
 */
function get_initial_filter_by_account(form_name)
{
	var account_id = window.document.forms[form_name].account_id.value;
	var account_name = escape(window.document.forms[form_name].account_name.value);
	var initial_filter = "&account_id=" + account_id + "&account_name=" + account_name;

	return initial_filter;
}
// end code from popup_parent_helper.js

// begin code for address copy
/**
 * This is a function used by the Address widget that will fill
 * in the given array fields using the fromKey and toKey as a
 * prefix into the form objects HTML elements.
 *
 * @param form The HTML form object to parse
 * @param fromKey The prefix of elements to copy from
 * @param toKey The prefix of elements to copy into
 * @return boolean true if successful, false otherwise
 */
function copyAddress(form, fromKey, toKey) {

    var elems = new Array("address_street", "address_city", "address_state", "address_postalcode", "address_country");
    var checkbox = document.getElementById(toKey + "_checkbox");

    if(typeof checkbox != "undefined") {
        if(!checkbox.checked) {
		    for(x in elems) {
		        t = toKey + "_" + elems[x];
			    document.getElementById(t).removeAttribute('readonly');
		    }
        } else {
		    for(x in elems) {
			    f = fromKey + "_" + elems[x];
			    t = toKey + "_" + elems[x];

			    document.getElementById(t).value = document.getElementById(f).value;
			    document.getElementById(t).setAttribute('readonly', true);
		    }
	    }
    }
  	return true;
}
// end code for address copy

/**
 * This function is used in Email Template Module.
 * It will check whether the template is used in Campaing->EmailMarketing.
 * If true, it will notify user.
 */

function check_deletable_EmailTemplate() {
	id = document.getElementsByName('record')[0].value;
	currentForm = document.getElementById('form');
	var call_back = {
		success:function(r) {
			if(r.responseText == 'true') {
				if(!confirm(SUGAR.language.get('app_strings','NTC_TEMPLATE_IS_USED'))) {
					return false;
				}
			} else {
				if(!confirm(SUGAR.language.get('app_strings','NTC_DELETE_CONFIRMATION'))) {
					return false;
				}
			}
			currentForm.return_module.value='EmailTemplates';
			currentForm.return_action.value='ListView';
			currentForm.action.value='Delete';
			currentForm.submit();
		}
		};
	url = "index.php?module=EmailTemplates&action=CheckDeletable&from=DetailView&to_pdf=1&record="+id;
	YAHOO.util.Connect.asyncRequest('POST',url, call_back,null);
}

SUGAR.image = {
     remove_upload_imagefile : function(field_name) {
            var field=document.getElementById('remove_imagefile_' + field_name);
            field.value=1;

            //enable the file upload button.
            var field=document.getElementById( field_name);
            field.style.display="";

            //hide the image and remove button.
            var field=document.getElementById('img_' + field_name);
            field.style.display="none";
            var field=document.getElementById('bt_remove_' + field_name);
            field.style.display="none";

            if(document.getElementById(field_name + '_duplicate')) {
               var field = document.getElementById(field_name + '_duplicate');
               field.value = "";
            }
    },

    confirm_imagefile : function(field_name) {
            var field=document.getElementById(field_name);
            var filename=field.value;
            var fileExtension = filename.substring(filename.lastIndexOf(".")+1);
            fileExtension = fileExtension.toLowerCase();
            if (fileExtension == "jpg" || fileExtension == "jpeg"
                || fileExtension == "gif" || fileExtension == "png" || fileExtension == "bmp"){
                    //image file
                }
            else{
                field.value=null;
                alert(SUGAR.language.get('app_strings', 'LBL_UPLOAD_IMAGE_FILE_INVALID'));
            }
    },

    lightbox : function(image)
	{
        if (typeof(SUGAR.image.lighboxWindow) == "undefined")
			SUGAR.image.lighboxWindow = new YAHOO.widget.SimpleDialog('sugarImageViewer', {
	            type:'message',
	            modal:true,
	            id:'sugarMsgWindow',
	            close:true,
	            title:"Alert",
	            msg: "<img src='" + image + "'> </img>",
	            buttons: [ ]
	        });
		SUGAR.image.lighboxWindow.setBody("<img src='" + image + "'> </img>");
		SUGAR.image.lighboxWindow.render(document.body);
        SUGAR.image.lighboxWindow.show();
		SUGAR.image.lighboxWindow.center()
    }
}

SUGAR.append(SUGAR.util, {
    isTouchScreen: function() {
        // first check if we have forced use of the touch enhanced interface
        if (Get_Cookie("touchscreen") == '1') {
            return true;
        }

        // next check if we should use the touch interface with our device
        if ((navigator.userAgent.match(/iPad/i) != null)) {
            return true;
        }

        return false;
    },

    isLoginPage:function (content) {
        //skip if this is packageManager screen
        if (SUGAR.util.isPackageManager()) {
            return false;
        }
        var loginPageStart = "<!DOCTYPE";
        if (content.substr(0, loginPageStart.length) == loginPageStart && content.indexOf("<html") != -1 && content.indexOf("login_module") != -1) {
            window.location.href = window.location.protocol + window.location.pathname;
            return true;
        }
    },

isPackageManager: function(){
	if(typeof(document.the_form) !='undefined' && typeof(document.the_form.language_pack_escaped) !='undefined'){
		return true;
	}else{return false;}
},

ajaxCallInProgress: function(){
    var t = true;
    //First check if we are in a popup.
    if (typeof (send_back) != "function"){
        //If the page content is blank, it means we are probably still waiting on something
        var c = document.getElementById("content");
        if (!c) return true;
        t = YAHOO.lang.trim(SUGAR.util.innerText(c));
    }
    return SUGAR_callsInProgress != 0 || t == "";
},
//Firefox doesn't support innerText (textContent includes script content)
innerText : function(el) {
    if (el.tagName == "SCRIPT")
        return "";
    if(typeof(el.innerText) == "string")
        return el.innerText;
    var t = "";
    for (var i in el.childNodes){
        var c = el.childNodes[i];
        if (typeof(c) != "object")
            continue;
        if (typeof(c.nodeName) == "string" && c.nodeName == "#text")
            t += c.nodeValue;
        else
            t += SUGAR.util.innerText(c);
    }
    return t;
},

callOnChangeListers: function(field){
	var listeners = YAHOO.util.Event.getListeners(field, 'change');
	if (listeners != null) {
		for (var i = 0; i < listeners.length; i++) {
			var l = listeners[i];
			l.fn.call(l.scope ? l.scope : this, l.obj);
		}
	}
},

closeActivityPanel: {
    show:function(module,id,new_status,viewType,parentContainerId){
        if (SUGAR.util.closeActivityPanel.panel)
			SUGAR.util.closeActivityPanel.panel.destroy();
	    var singleModule = SUGAR.language.get("app_list_strings", "moduleListSingular")[module];
	    singleModule = typeof(singleModule != 'undefined') ? singleModule.toLowerCase() : '';
	    var closeText =  SUGAR.language.get("app_strings", "LBL_CLOSE_ACTIVITY_CONFIRM").replace("#module#",singleModule);
        SUGAR.util.closeActivityPanel.panel =
	    new YAHOO.widget.SimpleDialog("closeActivityDialog",
	             { width: "300px",
	               fixedcenter: true,
	               visible: false,
	               draggable: false,
	               close: true,
	               text: closeText,
	               constraintoviewport: true,
	               buttons: [ { text:SUGAR.language.get("app_strings", "LBL_EMAIL_OK"), handler:function(){
	                   if (SUGAR.util.closeActivityPanel.panel)
                            SUGAR.util.closeActivityPanel.panel.hide();

                        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
                        var args = "action=save&id=" + id + "&record=" + id + "&status=" + new_status + "&module=" + module;
                        // 20110307 Frank Steegmans: Fix for bug 42361, Any field with a default configured in any activity will be set to this default when closed using the close dialog
                        // TODO: Take id out and regression test. Left id in for now to not create any other unexpected problems
                        //var args = "action=save&id=" + id + "&status=" + new_status + "&module=" + module;
                        var callback = {
                            success:function(o)
                            {
                                // Bug 51984: We need to submit the form just incase we have a form already submitted
                                // so we dont get a popup stating that the form needs to be resubmitted like it doesn,
                                // when you do a reload/refresh
                                window.setTimeout(function(){if(document.getElementById('search_form')) document.getElementById('search_form').submit(); else window.location.reload(true);}, 0);
                            },
                            argument:{'parentContainerId':parentContainerId}
                        };

                        YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, args);

	               }, isDefault:true },
	                          { text:SUGAR.language.get("app_strings", "LBL_EMAIL_CANCEL"),  handler:function(){SUGAR.util.closeActivityPanel.panel.hide(); }} ]
	             } );

	    SUGAR.util.closeActivityPanel.panel.setHeader(SUGAR.language.get("app_strings", "LBL_CLOSE_ACTIVITY_HEADER"));
        SUGAR.util.closeActivityPanel.panel.render(document.body);
        SUGAR.util.closeActivityPanel.panel.show();
    }
},

setEmailPasswordDisplay: function(id, exists, formName) {
	link = document.getElementById(id+'_link');
	pwd = document.getElementById(id);
	if(!pwd || !link) return;
	if(exists) {
            pwd.disabled = true;
    	pwd.style.display = 'none';
    	link.style.display = '';
        if(typeof(formName) != 'undefined')
            removeFromValidate(formName, id);
	} else {
            pwd.disabled = false;
    	pwd.style.display = '';
    	link.style.display = 'none';
	}
},

setEmailPasswordEdit: function(id) {
	link = document.getElementById(id+'_link');
	pwd = document.getElementById(id);
	if(!pwd || !link) return;
        pwd.disabled = false;
	pwd.style.display = '';
	link.style.display = 'none';
},

    /**
     * Compares a filename with a supplied array of allowed file extensions.
     * @param fileName string
     * @param allowedTypes array of allowed file extensions
     * @return bool
     */
    validateFileExt: function(fileName, allowedTypes) {
        var ext = fileName.split('.').pop().toLowerCase();

        for (var i = allowedTypes.length; i >= 0; i--) {
            if (ext === allowedTypes[i]) {
                return true;
            }
        }

        return false;
    },

    arrayIndexOf: function(arr, val, start) {
        if (typeof arr.indexOf == "function")
            return arr.indexOf(val, start);
        for (var i = (start || 0), j = arr.length; i < j; i++) {
            if (arr[i] === val) {
                return i;
            }
        }
        return -1;
    }
});

SUGAR.clearRelateField = function(form, name, id)
{
    if (typeof form[name] == "object"){
        form[name].value = '';
        SUGAR.util.callOnChangeListers(form[name]);
    }

    if (typeof form[id] == "object"){
        form[id].value = '';
        SUGAR.util.callOnChangeListers(form[id]);
    }
};
if(typeof(SUGAR.AutoComplete) == 'undefined') SUGAR.AutoComplete = {};

SUGAR.AutoComplete.getOptionsArray = function(options_index){
    var return_arr = [];

    var opts = SUGAR.language.get('app_list_strings', options_index);
    if(typeof(opts) != 'undefined'){
        for(key in opts){
            // Since we are using auto complete, we excluse blank dropdown entries since they can just leave it blank
            if(key != '' && opts[key] != ''){
                var item = [];
                item['key'] = key;
                item['text'] = opts[key];
                return_arr.push(item);
            }
        }
    }
    return return_arr;
}

if(typeof(SUGAR.MultiEnumAutoComplete) == 'undefined') SUGAR.MultiEnumAutoComplete = {};

SUGAR.MultiEnumAutoComplete.getMultiSelectKeysFromValues = function(options_index, val_string){
    var opts = SUGAR.language.get('app_list_strings', options_index);
    var selected_values = val_string.split(", ");
    // YUI AutoComplete adds a blank. We remove it automatically here
    if(selected_values.length > 0 && selected_values.indexOf('') == selected_values.length - 1){
        selected_values.pop();
    }
    var final_arr = new Array();
    for(idx in selected_values){
        for(o_idx in opts){
            if(selected_values[idx] == opts[o_idx]){
                final_arr.push(o_idx);
            }
        }
    }
    return final_arr;
}

SUGAR.MultiEnumAutoComplete.getMultiSelectValuesFromKeys = function(options_index, val_string){
    var opts = SUGAR.language.get('app_list_strings', options_index);
    val_string=val_string.replace(/^\^/,'').replace(/\^$/,'') //fixes bug where string starts or ends with ^
    var selected_values = val_string.split("^,^");

    // YUI AutoComplete adds a blank. We remove it automatically here
    if(selected_values.length > 0 && selected_values.indexOf('') == selected_values.length - 1){
        selected_values.pop();
    }

    var final_arr = new Array();
    for(idx in selected_values){
        for(o_idx in opts){
            if(selected_values[idx] == o_idx){
                final_arr.push(opts[o_idx]);
            }
        }
    }
    return final_arr;
}

SUGAR.VERSION_MARK = "";

function convertReportDateTimeToDB(dateValue, timeValue)
{
    var date_match = dateValue.match(date_reg_format);
    var time_match = timeValue.match(/([0-9]{1,2})\:([0-9]{1,2})([ap]m)/);
    if ( date_match != null && time_match != null) {
        time_match[1] = parseInt(time_match[1]);
        if (time_match[3] == 'pm') {
            time_match[1] = time_match[1] + 12;
            if (time_match[1] >= 24) {
                time_match[1] = time_match[1] - 24;
            }
        } else if (time_match[3] == 'am' && time_match[1] == 12) {
            time_match[1] = 0;
        }
        if (time_match[1] < 10) {
            time_match[1] = '0' + time_match[1];
        }
        return date_match[date_reg_positions['Y']] + "-"+date_match[date_reg_positions['m']] + "-"+date_match[date_reg_positions['d']] + ' '+ time_match[1] + ':' + time_match[2] + ':00';
    }
    return '';
}

/* End of File include/javascript/sugar_3.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */


// TODO this file is here only temporarily
SUGAR.ajaxUI = {
    loadingWindow : false,

    showErrorMessage : function(errorMessage)
    {
        if (!SUGAR.ajaxUI.errorPanel) {
                SUGAR.ajaxUI.errorPanel = new YAHOO.widget.Panel("ajaxUIErrorPanel", {
                    modal: false,
                    visible: true,
                    constraintoviewport: true,
                    width	: "800px",
                    height : "600px",
                    close: true
                });
            }
            var panel = SUGAR.ajaxUI.errorPanel;
            panel.setHeader(SUGAR.language.get('app_strings','ERR_AJAX_LOAD')) ;
            panel.setBody('<iframe id="ajaxErrorFrame" style="width:780px;height:550px;border:none;marginheight="0" marginwidth="0" frameborder="0""></iframe>');
            panel.setFooter(SUGAR.language.get('app_strings','ERR_AJAX_LOAD_FOOTER')) ;
            panel.render(document.body);
            SUGAR.util.doWhen(
				function(){
					var f = document.getElementById("ajaxErrorFrame");
					return f != null && f.contentWindow != null && f.contentWindow.document != null;
				}, function(){
					document.getElementById("ajaxErrorFrame").contentWindow.document.body.innerHTML = errorMessage;
					window.setTimeout('throw "AjaxUI error parsing response"', 300);
			});

            //fire off a delayed check to make sure error message was rendered.
            SUGAR.ajaxUI.errorMessage = errorMessage;
            window.setTimeout('if((typeof(document.getElementById("ajaxErrorFrame")) == "undefined" || typeof(document.getElementById("ajaxErrorFrame")) == null  || document.getElementById("ajaxErrorFrame").contentWindow.document.body.innerHTML == "")){document.getElementById("ajaxErrorFrame").contentWindow.document.body.innerHTML=SUGAR.ajaxUI.errorMessage;}',3000);

            panel.show();
            panel.center();

            throw "AjaxUI error parsing response";
    },
    canAjaxLoadModule : function(module)
    {
        var checkLS = /&LicState=check/.exec(window.location.search);

        // Return false if ajax ui is completely disabled, or if license state is set to check
        if( checkLS || (typeof(SUGAR.config.disableAjaxUI) != 'undefined' && SUGAR.config.disableAjaxUI == true)){
            return false;
        }
        
        var bannedModules = SUGAR.config.stockAjaxBannedModules;
        //If banned modules isn't there, we are probably on a page that isn't ajaxUI compatible
        if (typeof(bannedModules) == 'undefined')
            return false;
        // Mechanism to allow for overriding or adding to this list
        if(typeof(SUGAR.config.addAjaxBannedModules) != 'undefined'){
            bannedModules.concat(SUGAR.config.addAjaxBannedModules);
        }
        if(typeof(SUGAR.config.overrideAjaxBannedModules) != 'undefined'){
            bannedModules = SUGAR.config.overrideAjaxBannedModules;
        }
        
        return SUGAR.util.arrayIndexOf(bannedModules, module) == -1;
    },

    loadContent : function(url, params)
    {
        if(YAHOO.lang.trim(url) != "")
        {
            //Don't ajax load certain modules
            var mRegex = /module=([^&]*)/.exec(url);
            var module = mRegex ? mRegex[1] : false;
            if (module && SUGAR.ajaxUI.canAjaxLoadModule(module))
            {
                YAHOO.util.History.navigate('ajaxUILoc',  url);
            } else {
                window.location = url;
            }
        }
    },

    go : function(url)
    {
        if(YAHOO.lang.trim(url) != "")
        {
            var con = YAHOO.util.Connect, ui = SUGAR.ajaxUI;
            if (ui.lastURL == url)
                return;
            var inAjaxUI = /action=ajaxui/.exec(window.location.href);
            if (typeof (window.onbeforeunload) == "function" && window.onbeforeunload())
            {
                //If there is an unload function, we need to check it ourselves
                if (!confirm(window.onbeforeunload()))
                {
                    if (!inAjaxUI)
                    {
                        //User doesn't want to navigate
                        window.location.hash = "";
                    }
                    else
                    {
                        YAHOO.util.History.navigate('ajaxUILoc',  ui.lastURL);
                    }
                    return;
                }
                window.onbeforeunload = null;
            }
            if (ui.lastCall && con.isCallInProgress(ui.lastCall)) {
                con.abort(ui.lastCall);
            }
            var mRegex = /module=([^&]*)/.exec(url);
            var module = mRegex ? mRegex[1] : false;
            //If we can't ajax load the module (blacklisted), set the URL directly.
            if (!ui.canAjaxLoadModule(module)) {
                window.location = url;
                return;
            }
            ui.lastURL = url;
            ui.cleanGlobals();
            var loadLanguageJS = '';
            if(module && typeof(SUGAR.language.languages[module]) == 'undefined'){
                loadLanguageJS = '&loadLanguageJS=1';
            }

            if (!inAjaxUI) {
                //If we aren't in the ajaxUI yet, we need to reload the page to get setup properly
                if (!SUGAR.isIE)
                    window.location.replace("index.php?action=ajaxui#ajaxUILoc=" + encodeURIComponent(url));
                else {
                    //if we use replace under IE, it will cache the page as the replaced version and thus no longer load the previous page.
                    window.location.hash = "#";
                    window.location.assign("index.php?action=ajaxui#ajaxUILoc=" + encodeURIComponent(url));
                }
            }
            else {
                SUGAR_callsInProgress++;
                SUGAR.ajaxUI.showLoadingPanel();
                ui.lastCall = YAHOO.util.Connect.asyncRequest('GET', url + '&ajax_load=1' + loadLanguageJS, {
                    success: SUGAR.ajaxUI.callback,
                    failure: function(){
                        SUGAR_callsInProgress--;
                        SUGAR.ajaxUI.hideLoadingPanel();
                        SUGAR.ajaxUI.showErrorMessage(SUGAR.language.get('app_strings','ERR_AJAX_LOAD_FAILURE'));
                    }
                });
            }
        }
    },

    submitForm : function(formname, params)
    {
        var con = YAHOO.util.Connect, SA = SUGAR.ajaxUI;
        if (SA.lastCall && con.isCallInProgress(SA.lastCall)) {
            con.abort(SA.lastCall);
        }
        //Reset the EmailAddressWidget before loading a new page
        SA.cleanGlobals();
        //Don't ajax load certain modules
        var form = YAHOO.util.Dom.get(formname) || document.forms[formname];
        if (SA.canAjaxLoadModule(form.module.value)
            //Do not try to submit a form that contains a file input via ajax.
            && typeof(YAHOO.util.Selector.query("input[type=file]", form)[0]) == "undefined"
            //Do not try to ajax submit a form if the ajaxUI is not initialized
            && /action=ajaxui/.exec(window.location.href))
        {
            var string = con.setForm(form);
            var baseUrl = "index.php?action=ajaxui#ajaxUILoc=";
            SA.lastURL = "";
            //Use POST for long forms and GET for short forms (GET allow resubmit via reload)
            if(string.length > 200)
            {
                SUGAR.ajaxUI.showLoadingPanel();
                form.onsubmit = function(){ return true; };
                form.submit();
            } else {
                con.resetFormState();
                window.location = baseUrl + encodeURIComponent("index.php?" + string);
            }
            return true;
        } else {

            if( typeof(YAHOO.util.Selector.query("input[type=submit]", form)[0]) != "undefined"
                    && YAHOO.util.Selector.query("input[type=submit]", form)[0].value == "Save")
            {
                ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
            }

            form.submit();
            return false;
        }
    },

    cleanGlobals : function()
    {
        sqs_objects = {};
        QSProcessedFieldsArray = {};
        collection = {};
        //Reset the EmailAddressWidget before loading a new page
        if (SUGAR.EmailAddressWidget){
            SUGAR.EmailAddressWidget.instances = {};
            SUGAR.EmailAddressWidget.count = {};
        }
        YAHOO.util.Event.removeListener(window, 'resize');
        //Hide any connector dialogs
        if(typeof(dialog) != 'undefined' && typeof(dialog.destroy) == 'function'){
            dialog.destroy();
            delete dialog;
        }

    },

    print: function()
    {
        var url = YAHOO.util.History.getBookmarkedState('ajaxUILoc');
        SUGAR.util.openWindow(
            url + '&print=true',
            'printwin',
            'menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1'
        );
    },
    showLoadingPanel: function()
    {
        if (!SUGAR.ajaxUI.loadingPanel)
        {
            SUGAR.ajaxUI.loadingPanel = new YAHOO.widget.Panel("ajaxloading",
            {
                width:"240px",
                fixedcenter:true,
                close:false,
                draggable:false,
                constraintoviewport:false,
                modal:true,
                visible:false
            });
            SUGAR.ajaxUI.loadingPanel.setBody('<div id="loadingPage" align="center" style="vertical-align:middle;"><img src="' + SUGAR.themes.loading_image + '" align="absmiddle" /> <b>' + SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE') +'</b></div>');
            SUGAR.ajaxUI.loadingPanel.render(document.body);
        }

        if (document.getElementById('ajaxloading_c'))
            document.getElementById('ajaxloading_c').style.display = '';
        
        SUGAR.ajaxUI.loadingPanel.show();

    },
    hideLoadingPanel: function()
    {
        SUGAR.ajaxUI.loadingPanel.hide();
        
        if (document.getElementById('ajaxloading_c'))
            document.getElementById('ajaxloading_c').style.display = 'none';
    },
    setFavicon: function(data)
    {
        var head = document.getElementsByTagName("head")[0];

        // first remove all rel="icon" links as long as updating an existing one
        // could take no effect
        var links = head.getElementsByTagName("link");
        var re = /\bicon\b/i;
        for (var i = 0; i < links.length; i++)        {
            if (re.test(links[i].rel))
            {
                head.removeChild(links[i]);
            }
        }

        var link = document.createElement("link");

        link.href = data.url;
        // type attribute is important for Google Chrome browser
        link.type = data.type;
        link.rel = "icon";
        head.appendChild(link);
    }
};

/* End of File include/javascript/ajaxUI.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

 // $Id: cookie.js 36440 2008-06-09 17:12:23Z dwheeler $
 
function Get_Cookie(name) {
  var start = document.cookie.indexOf(name + '=');
  var len = start + name.length + 1;
  if ((!start) && (name != document.cookie.substring(0,name.length)))
    return null;
  if (start == -1)
    return null;
  var end = document.cookie.indexOf(';',len);
  if (end == -1) end = document.cookie.length;
  if(end == start){
  	return '';
  }
  return unescape(document.cookie.substring(len,end));
}

function Set_Cookie( name, value, expires, path, domain, secure ) 
{
// set time, it's in milliseconds
var today = new Date();
today.setTime( today.getTime() );

/*
if the expires variable is set, make the correct 
expires time, the current script below will set 
it for x number of days, to make it for hours, 
delete * 24, for minutes, delete * 60 * 24
*/
if ( expires )
{
expires = expires * 1000 * 60 * 60 * 24;
}
var expires_date = new Date( today.getTime() + (expires) );

document.cookie = name + "=" +escape( value ) +
( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
( ( path ) ? ";path=" + path : "" ) + 
( ( domain ) ? ";domain=" + domain : "" ) +
( ( secure ) ? ";secure" : "" );
}

function Delete_Cookie(name,path,domain) {
  if (Get_Cookie(name))
    document.cookie =
      name + '=' +
      ( (path) ? ';path=' + path : '') +
      ( (domain) ? ';domain=' + domain : '') +
      ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
}

/*
returns an array of cookie values from a single cookie
*/
function get_sub_cookies(cookie){
	var cookies = new Array();
	var end ='';
	if(cookie && cookie != ''){
		end = cookie.indexOf('#')
		while(end > -1){
			var cur = cookie.substring(0, end);
			 cookie = cookie.substring(end + 1, cookie.length);
			var name = cur.substring(0, cur.indexOf('='));
			var value = cur.substring(cur.indexOf('=') + 1, cur.length);
			cookies[name] = value;
			
			end = cookie.indexOf('#')
		}
	}
	return cookies;
}

function subs_to_cookie(cookies){

	
	var cookie = '';
		for (var i in cookies)
		{
			if (typeof(cookies[i]) != "function") {
				cookie += i  + '=' + cookies[i] + '#';
			}
		}
	return cookie;
}

/* End of File include/javascript/cookie.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */


var menuStack = new Array();
var hiddenElmStack = new Array();
var currentMenu = null;
var closeMenusDelay = null;
var openMenusDelay = null;
var delayTime = 75;					// ms for menu open delay


function eraseTimeout(tId) {
	//if (tId != null)
	window.clearTimeout(tId);
	return null;
}

function tbButtonMouseOverOrig(id){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	var menuName = id.replace(/Handle/i,'Menu');
	var menu = getLayer(menuName);
	//if (menu) menu.className = 'tbButtonMouseOverUp';
	if (currentMenu){
		closeAllMenus();
	}
	popupMenu(id, menu);
}
function tbButtonMouseOver(id,top,left,leftOffset){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	if (openMenusDelay == null){
		openMenusDelay = window.setTimeout("showMenu('"+id+"','"+top+"','"+left+"','"+leftOffset+"')", delayTime);
	}
}
function showMenu(id,top,left,leftOffset){
	openMenusDelay = eraseTimeout(openMenusDelay);
	var menuName = id.replace(/Handle/i,'Menu');
	var menu = getLayer(menuName);
	//if (menu) menu.className = 'tbButtonMouseOverUp';
	if (currentMenu){
		closeAllMenus();
	}
	popupMenu(id, menu, top,left,leftOffset);
}

function showSubMenu(id){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	var menuName = id.replace(/Handle/i,'Menu');
	var menu = getLayer(menuName);
//	if (currentMenu){
//		closeMenus();
//	}
//	popupMenu(id, menu);
	popupSubMenu(id, menu);
}

function popupMenu(handleID, menu, top, left, leftOffset){
	var bw = checkBrowserWidth();
	var menuName = handleID.replace(/Handle/i,'Menu');
	var menuWidth = 120;
	var imgWidth = document.getElementById(handleID).width;
	if (menu){
		var menuHandle = getLayer(handleID);
		var p=menuHandle;
		if (left == "") {
		var left = 0;
		while(p&&p.tagName.toUpperCase()!='BODY'){
			left+=p.offsetLeft;
			p=p.offsetParent;
		}
		left+=parseInt(leftOffset);
			
		}
		if (left+menuWidth>bw) {
			left = left-menuWidth+imgWidth;
		}
		setMenuVisible(menu, left, top, false);
	}
}


function popupSubMenu(handleID, menu){
	if (menu){
		var menuHandle = getLayer(handleID);
		var p=menuHandle;
		//var top = p.offsetHeight, left = 0;
		var top = 0, left = p.offsetWidth;
		while(p&&p.tagName.toUpperCase()!='BODY'){
			top+=p.offsetTop;
			left+=p.offsetLeft;
			p=p.offsetParent;
		}
		if (is.ie && is.mac){
			top -= 3;
			left -= 10;
		}
/*
		if (menu.isSubMenu){
			try{
				if (blnNetscape6){
					left+=(getLayer(menu.parentid).offsetWidth - 4);
				}else{
					left+=(getLayer(menu.parentid).clientWidth - 8);
				}
			}catch(e){
			}
		}else{
			top += menuItem.offsetHeight;
		}
*/
		//menu.x = left;
		//menu.y = top;
		setMenuVisible(menu, left, top, true);
		//fixWidth(paneID, menu);
	}
}

function closeMenusOrig(){
	if (currentMenu){
		setMenuVisibility(currentMenu, false);
//		currentMenu = null;
	}
}

function closeSubMenus(handle){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	if (menuStack.length > 0){
		for (var i = menuStack.length-1; i >=0; i--){
			var menu = menuStack[menuStack.length-1];
			if (menu.id == handle.getAttribute('parentid')){
				currentMenu = menu;
				break;
			}else{
				closeMenu(menu);
				//menuStack.pop();
				menuPop();
			}
		}
	}
}

function closeMenu(menu){
	setMenuVisibility(menu, false);
}

function closeMenusOrig(){
	if (menuStack.length > 0){
		for (var i = menuStack.length-1; i >=0; i--){
			//var menu = menuStack.pop();
			var menu = menuPop();
			closeMenu(menu);
		}
	}
	currentMenu = null;
}

function closeMenus(){
	if (closeMenusDelay == null){
		closeMenusDelay = window.setTimeout("closeAllMenus()", delayTime);
	}
}

function closeAllMenus(){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	if (menuStack.length > 0){
		for (var i = menuStack.length-1; i >=0; i--){
			//var menu = menuStack.pop();
			var menu = menuPop();
			closeMenu(menu);
		}
	}
	currentMenu = null;
}

function setMenuVisible(menu, x, y, isSubMenu){
/*
   var id = menu.id;
   var left=0;
   var top=0;
   var menuItem = menu.getMenuItemElm();

   if (menuItem && menu){
      if (menu.isTopMenu){
         menuItem.className = 'tbButtonMouseDown';
      }
   }
*/
	if (menu){
		//menu.x = left;
		//menu.y = top;
		if (isSubMenu){
			if (menu.getAttribute('parentid') == currentMenu.getAttribute('parentid')){
				//menuStack.pop();
				menuPop();
				setMenuVisibility(currentMenu, false);
			}
		}else{
			//menuStack.pop();
			menuPop();
			setMenuVisibility(currentMenu, false);
		}
		currentMenu = menu;
		//menuStack.push(menu);
		menuPush(menu);
		setMenuVisibility(menu, true, x, y);
	}
}

function getLayer(layerid){
/*
	if (document.layers && layerid){
		if (document.layers[layerid]) return document.layers[layerid];
	}
	if (document.links && layerid){
		if (document.links[layerid]) return document.links[layerid];
	}
	if (document.all && layerid){
		if (document.all(layerid)) return document.all(layerid);
	}
*/
	return document.getElementById(layerid);
}

function setMenuVisibility(menu, on, x, y){
	var parent = menu;
	if (menu){
/*
		menu.visible = on;
		setLayer(menu.id, !menu.visible, menu.x, menu.y);
		setLayer(menu.id, !menu.visible, 0, 0);
		menu.visible = on;
*/
		setLayer(menu.id, !on, x, y);
		if (is.ie){
			if (!on){
				if (!menu.getAttribute('parentid')){
					showElement("SELECT");
				}
			}else{
				hideElement("SELECT", x, y, menu.offsetWidth, menu.offsetHeight);
			}
		}
/*
		setLayer(menu.id, !menu.visible, 0, 0);
		var menuWidth, menuHeight;
		var menuLayer = getLayer(menu.id);
		if (menuLayer){
			if (blnIE55){
				menuWidth = menuLayer.clientWidth;
				menuHeight = menuLayer.clientHeight;
			}else{
				menuWidth = menuLayer.offsetWidth;
				menuHeight = menuLayer.offsetHeight;
			}
			if (menu.x+menuWidth > clientWindowWidth){
				menu.x = clientWindowWidth - menuWidth - 25;
				if (menu.x < 10){
					menu.x = 10;
				}
			}
			if (menu.y+menuHeight > clientWindowHeight){
				menu.y = clientWindowHeight - menuHeight - 25;
				if (menu.y < 10){
					menu.y = 10;
				}
			}
			setLayer(menu.id, !menu.visible, menu.x, menu.y);
		}
*/
	}
/*
	var parentid = menu.parentid;
	while (parentid){
		parent = getMenu(menu.paneID, parentid);
		if (parent){
			parent.visible = on;
			setLayer(parent.id, !parent.visible, parent.x, parent.y);
			parentid = parent.parentid;
			if (on == false) currentMenu = parent;
		}else{
			parentid = null;
		}
	}
	}
	return parent;
*/
}

function menuPop(){
	if (is.ie && (is.mac || !is.ie5_5up)){
		var menu = menuStack[menuStack.length-1];
		var newMenuStack = new Array();
		for (var i = 0; i < menuStack.length-1; i++){
			newMenuStack[newMenuStack.length] = menuStack[i];
		}
		menuStack = newMenuStack;
		return menu;
	}else{
		return menuStack.pop();
	}
}

function menuPush(menu){
	if (is.ie && (is.mac || !is.ie5_5up)){
		menuStack[menuStack.length] = menu;
	}else{
		menuStack.push(menu);
	}
}

function checkBrowserWidth(){
	var	windowWidth;
	if (is.ie){
		windowWidth = document.body.clientWidth;
	}else{
		// 17px for scrollbar width
		windowWidth = window.innerWidth - 16;
	}
	if (windowWidth >= 1000){
		showSB('sbContent',true,'sb');
	}else{
		showSB('sbContent',false,'sb');
	}
	return windowWidth;
}

function showSB(id, hideit, imgIdPrefix){
	setLayer(id, !hideit, -1, -1);
	setLayer(imgIdPrefix+'On', !hideit, -1, -1);
	setLayer(imgIdPrefix+'Off', hideit, -1, -1);
}

function setLayer(id, hidden, x, y){
	var layer = getLayer(id);
	setLayerElm(layer, hidden, x, y);
}

function setLayerElm(layer, hideit, x, y){
	if (layer && layer.style){
		if (hideit){
			layer.style.visibility='hidden';
			//layer.style.display='none';
		}else{
			layer.style.display='block';
			layer.style.visibility='visible';
		}
		if (x >=0 && x != ""){
            //alert(layer.id+': '+x+', '+y+'\n'+layer.offsetLeft+', '+layer.offsetTop);
			//layer.style.left=x;
			//layer.style.top=y;
			layer.style.left = x+'px';
		}
		if (y >= 0 && y != "") {
			layer.style.top = y+'px';
		}
	}
}

function hiliteItem(menuItem,changeClass){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	if (changeClass=='yes') {
		if (menuItem.getAttribute('avid') == 'false'){
			menuItem.className = 'menuItemHiliteX';
		}else{
			menuItem.className = 'menuItemHilite';
		}
	}
}
function unhiliteItem(menuItem){
	closeMenusDelay = eraseTimeout(closeMenusDelay);
	if (menuItem.getAttribute('avid') == 'false'){
		menuItem.className = 'menuItemX';
	}else{
		menuItem.className = 'menuItem';
	}
}

function showElement(elmID){
	for (i = 0; i < document.getElementsByTagName(elmID).length; i++)	{
		obj = document.getElementsByTagName(elmID)[i];
		if (! obj || ! obj.offsetParent)
			continue;
		obj.style.visibility = "";
	}
}
function showElementNew(elmID){
	if (hiddenElmStack.length > 0){
		for (var i = hiddenElmStack.length-1; i >=0; i--){
			var obj = hiddenElmStack[hiddenElmStack.length-1];
			obj.style.visibility = "";;
			hiddenElmStack.pop();
		}
	}
}

function hideElement(elmID,x,y,w,h){
	for (i = 0; i < document.getElementsByTagName(elmID).length; i++){
		obj = document.getElementsByTagName(elmID)[i];
		if (! obj || ! obj.offsetParent)
			continue;

		// Find the element's offsetTop and offsetLeft relative to the BODY tag.
		objLeft   = obj.offsetLeft;
		objTop    = obj.offsetTop;
		objParent = obj.offsetParent;
		while (objParent.tagName.toUpperCase() != "BODY"){
			objLeft  += objParent.offsetLeft;
			objTop   += objParent.offsetTop;
			if(objParent.offsetParent == null)
				break;
			else
				objParent = objParent.offsetParent;
		}
		// Adjust the element's offsetTop relative to the dropdown menu
		objTop = objTop - y;

		if (x > (objLeft + obj.offsetWidth) || objLeft > (x + w))
			;
		else if (objTop > h)
			;
		else if ((y + h) <= 80)
			;
		else {
			obj.style.visibility = "hidden";
			//hiddenElmStack.push(obj);
		}
	}
}

function Is (){
    // convert all characters to lowercase to simplify testing
    var agt = navigator.userAgent.toLowerCase();

    // *** BROWSER VERSION ***
    // Note: On IE5, these return 4, so use is.ie5up to detect IE5.
    this.major = parseInt(navigator.appVersion);
    this.minor = parseFloat(navigator.appVersion);

    // Note: Opera and WebTV spoof Navigator.  We do strict client detection.
    // If you want to allow spoofing, take out the tests for opera and webtv.
    this.nav  = ((agt.indexOf('mozilla')!=-1) && (agt.indexOf('spoofer')==-1)
                && (agt.indexOf('compatible') == -1) && (agt.indexOf('opera')==-1)
                && (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1));
    this.nav2 = (this.nav && (this.major == 2));
    this.nav3 = (this.nav && (this.major == 3));
    this.nav4 = (this.nav && (this.major == 4));
    this.nav4up = (this.nav && (this.major >= 4));
    this.navonly      = (this.nav && ((agt.indexOf(";nav") != -1) ||
                          (agt.indexOf("; nav") != -1)) );
    this.nav6 = (this.nav && (this.major == 5));
    this.nav6up = (this.nav && (this.major >= 5));
    this.gecko = (agt.indexOf('gecko') != -1);

    this.nav7 = (this.gecko && (this.major >= 5) && (agt.indexOf('netscape/7')!=-1));
    this.moz1 = false;
    this.moz1up = false;
    this.moz1_1 = false;
    this.moz1_1up = false;
    if (this.nav6up){
//    if (this.nav){
       myRegEx = new RegExp("rv:\\d*.\\d*.\\d*");
       //myFind = myRegEx.exec("; rv:9.10.5)");
       myFind = myRegEx.exec(agt);
	   if(myFind!=null){
         var strVersion = myFind.toString();
         strVersion = strVersion.replace(/rv:/,'');
         var arrVersion = strVersion.split('.');
         var major = parseInt(arrVersion[0]);
         var minor = parseInt(arrVersion[1]);
         if (arrVersion[2]) var revision = parseInt(arrVersion[2]);
         this.moz1 = ((major == 1) && (minor == 0));
         this.moz1up = ((major == 1) && (minor >= 0));
         this.moz1_1 = ((major == 1) && (minor == 1));
         this.moz1_1up = ((major == 1) && (minor >= 1));
	  }
    }

    this.ie     = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
    this.ie3    = (this.ie && (this.major < 4));
    this.ie4    = (this.ie && (this.major == 4) && (agt.indexOf("msie 4")!=-1) );
    this.ie4up  = (this.ie  && (this.major >= 4));
    this.ie5    = (this.ie && (this.major == 4) && (agt.indexOf("msie 5.0")!=-1) );
    this.ie5_5  = (this.ie && (this.major == 4) && (agt.indexOf("msie 5.5") !=-1));
    this.ie5up  = (this.ie  && !this.ie3 && !this.ie4);

    this.ie5_5up =(this.ie && !this.ie3 && !this.ie4 && !this.ie5);
    this.ie6    = (this.ie && (this.major == 4) && (agt.indexOf("msie 6.")!=-1) );
    this.ie6up  = (this.ie  && !this.ie3 && !this.ie4 && !this.ie5 && !this.ie5_5);

	this.mac    = (agt.indexOf("mac") != -1);
}

function runPageLoadItems (){
	var myVar;
	checkBrowserWidth();
}
var is = new Is();

if (is.ie) {
	document.write('<style type="text/css">');
	document.write('body {font-size: x-small;}');
	document.write ('</style>');
}

/* End of File include/javascript/menu.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

Calendar = function() {};

Calendar.getHighestZIndex = function (containerEl)
{
   var highestIndex = 0;
   var currentIndex = 0;
   var els = Array();
   
   els = containerEl ? containerEl.getElementsByTagName('*') : document.getElementsByTagName('*');
   
   for(var i=0; i < els.length; i++)
   {
      currentIndex = YAHOO.util.Dom.getStyle(els[i], "zIndex");
      if(!isNaN(currentIndex) && currentIndex > highestIndex)
      { 
      	 highestIndex = parseInt(currentIndex); 
      }
   }
   
   return (highestIndex == Number.MAX_VALUE) ? Number.MAX_VALUE : highestIndex+1;
};

Calendar.setup = function (params) {

    YAHOO.util.Event.onDOMReady(function(){
    	
        var Event = YAHOO.util.Event;
        var Dom = YAHOO.util.Dom;
        var dialog;
        var calendar;
        var showButton = params.button ? params.button : params.buttonObj;
        var userDateFormat = params.ifFormat ? params.ifFormat : (params.daFormat ? params.daFormat : "m/d/Y");
        var inputField = params.inputField ? params.inputField : params.inputFieldObj;
        var startWeekday = params.startWeekday ? params.startWeekday : 0;
        var dateFormat = userDateFormat.substr(0,10);
        var date_field_delimiter = /([-.\\/])/.exec(dateFormat)[0];
        dateFormat = dateFormat.replace(/[^a-zA-Z]/g,'');
                
        var monthPos = dateFormat.search(/m/);
        var dayPos = dateFormat.search(/d/);
        var yearPos = dateFormat.search(/Y/);         
        
        var dateParams = new Object();
        dateParams.delim = date_field_delimiter;  
        dateParams.monthPos = monthPos;
        dateParams.dayPos = dayPos;
        dateParams.yearPos = yearPos;
        
        var showButtonElement = Dom.get(showButton);
        Event.on(showButtonElement, "click", function() {

            if (!dialog) {
                                  
                dialog = new YAHOO.widget.SimpleDialog("container_" + showButtonElement.id, {
                    visible:false,
                    context:[showButton, "tl", "bl", null, [-175,5]],
                    buttons:[],
                    draggable:false,
                    close:true,
                    zIndex: Calendar.getHighestZIndex(document.body),
                    constraintoviewport:true
                });
                
                dialog.setHeader(SUGAR.language.get('app_strings', 'LBL_MASSUPDATE_DATE'));
                var dialogBody = '<p class="callnav_today"><a href="javascript:void(0)"  id="callnav_today">' + SUGAR.language.get('app_strings', 'LBL_EMAIL_DATE_TODAY') + '</a></p><div id="' + showButtonElement.id + '_div"></div>';
                dialog.setBody(dialogBody);
                dialog.render(document.body);

                //Since the cal div name is dynamic we need to add a custom class to override some default yui css styles
                Dom.addClass("container_" + showButtonElement.id, "cal_panel");
                
                //Clear the date selection if the user clicks on today.
                Event.addListener("callnav_today", "click", function(){ 
                    calendar.clear();
                    var now = new Date();
                    //Reset the input field value
                    var input = Dom.get(inputField);
                    input.value = formatSelectedDate(now);
                    //Highlight the cell
                    var cellIndex = calendar.getCellIndex(now);
                    if(cellIndex > -1 )
                    {
                        var cell = calendar.cells[cellIndex];
                        Dom.addClass(cell, calendar.Style.CSS_CELL_SELECTED);
                    }

                    //bug 50740 - explicitly fire onchange event for this input
                    if(input.onchange)
                        input.onchange();

                    //Fire any on-change events for this input field
                    SUGAR.util.callOnChangeListers(input);

                    //Must return false to prevent onbeforeunload from firing in IE8
                    return false;
                });
                
                dialog.showEvent.subscribe(function() {
                    if (YAHOO.env.ua.ie) {
                        // Since we're hiding the table using yui-overlay-hidden, we 
                        // want to let the dialog know that the content size has changed, when
                        // shown
                        dialog.fireEvent("changeContent");
                    }
                });
                
                // Hide Calendar if we click anywhere in the document other than the calendar
                Event.on(document, "click", function(e) {
                	
                    if(!dialog)
                    {
                       return;	
                    }                	
                	
                    var el = Event.getTarget(e);                   
                    var dialogEl = dialog.element;
                    if (el != dialogEl && !Dom.isAncestor(dialogEl, el) && el != showButtonElement && !Dom.isAncestor(showButtonElement, el)) {
                        dialog.hide();
                    }
                });                
            }

            // Lazy Calendar Creation - Wait to create the Calendar until the first time the button is clicked.
            if (!calendar) {
                var navConfig = {
                    strings : {
                        month: SUGAR.language.get('app_strings', 'LBL_CHOOSE_MONTH'),
                        year: SUGAR.language.get('app_strings', 'LBL_ENTER_YEAR'),
                        submit: SUGAR.language.get('app_strings', 'LBL_EMAIL_OK'),
                        cancel: SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL'),
                        invalidYear: SUGAR.language.get('app_strings', 'LBL_ENTER_VALID_YEAR')
                    },
                    monthFormat: YAHOO.widget.Calendar.SHORT,
                    initialFocus: "year"
                };               	
            	
                calendar = new YAHOO.widget.Calendar(showButtonElement.id + '_div', {
                    iframe:false,
                    hide_blank_weeks:true,
                    navigator:navConfig
                });
                
                calendar.cfg.setProperty('DATE_FIELD_DELIMITER', date_field_delimiter);
                calendar.cfg.setProperty('MDY_DAY_POSITION', dayPos+1);
                calendar.cfg.setProperty('MDY_MONTH_POSITION', monthPos+1);
                calendar.cfg.setProperty('MDY_YEAR_POSITION', yearPos+1);
                calendar.cfg.setProperty('START_WEEKDAY', startWeekday);
                
                //Configure the month and days label with localization support where defined
                if(typeof SUGAR.language.languages['app_list_strings'] != 'undefined' && SUGAR.language.languages['app_list_strings']['dom_cal_month_long'] != 'undefined')
                {
                	if(SUGAR.language.languages['app_list_strings']['dom_cal_month_long'].length == 13)
                	{
                	   SUGAR.language.languages['app_list_strings']['dom_cal_month_long'].shift();
                	}
                	calendar.cfg.setProperty('MONTHS_LONG', SUGAR.language.languages['app_list_strings']['dom_cal_month_long']);
                }
                
                if(typeof SUGAR.language.languages['app_list_strings'] != 'undefined'  && typeof SUGAR.language.languages['app_list_strings']['dom_cal_day_short'] != 'undefined')
                {
                	if(SUGAR.language.languages['app_list_strings']['dom_cal_day_short'].length == 8)
                	{
                	   SUGAR.language.languages['app_list_strings']['dom_cal_day_short'].shift();
                	}                	
                	calendar.cfg.setProperty('WEEKDAYS_SHORT', SUGAR.language.languages['app_list_strings']['dom_cal_day_short']);
                }

                var formatSelectedDate = function(selDate)
                {
                    var monthVal = selDate.getMonth() + 1; //Add one for month value
                    if(monthVal < 10)
                    {
                        monthVal = '0' + monthVal;
                    }

                    var dateVal = selDate.getDate();

                    if(dateVal < 10)
                    {
                        dateVal = '0' + dateVal;
                    }

                    var yearVal = selDate.getFullYear();

                    selDate = '';
                    if(monthPos == 0)
                    {
                        selDate = monthVal;
                    }
                    else if(dayPos == 0)
                    {
                        selDate = dateVal;
                    }
                    else
                    {
                        selDate = yearVal;
                    }

                    if(monthPos == 1)
                    {
                        selDate += date_field_delimiter + monthVal;
                    }
                    else if(dayPos == 1)
                    {
                        selDate += date_field_delimiter + dateVal;
                    }
                    else
                    {
                        selDate += date_field_delimiter + yearVal;
                    }

                    if(monthPos == 2)
                    {
                        selDate += date_field_delimiter + monthVal;
                    }
                    else if(dayPos == 2)
                    {
                        selDate += date_field_delimiter + dateVal;
                    }
                    else
                    {
                        selDate += date_field_delimiter + yearVal;
                    }

                    return selDate;
                };

                calendar.selectEvent.subscribe(function(type, args, obj) {

                    var input = Dom.get(inputField);
					if (calendar.getSelectedDates().length > 0) {

                        input.value = formatSelectedDate(calendar.getSelectedDates()[0]);
                        
                        if(params.comboObject)
                        {
                           params.comboObject.update();
                        }
                    } else if(typeof args[0][0] == 'object') {
                        //We resort to using the args parameter to set the date should calendar.getSelectedDates return an empty array
                        selDate = args[0][0];
                        input.value = formatSelectedDate(new Date(selDate[0], selDate[1], selDate[2]));
                    } else {
                        input.value = '';
                    }
					
					//bug 44147 fix
                    //does not trigger onchange event
                    if(input.onchange)
                    	input.onchange();
                    //end bugfix
                    

                    dialog.hide();
					//Fire any on-change events for this input field
					SUGAR.util.callOnChangeListers(input);
                });

                calendar.renderEvent.subscribe(function() {
                    // Tell Dialog it's contents have changed, which allows 
                    // container to redraw the underlay (for IE6/Safari2)
                    dialog.fireEvent("changeContent");
                });
               
            }
            
            var sanitizeDate = function(date, dateParams){
            	var dateArray = Array();
            	var returnArray = Array('','','');
            	var delimArray = Array(".", "/", "-");
            	var dateCheck = 0;
            	
            	for (var delimCounter = 0; delimCounter < delimArray.length; delimCounter++){
            		dateArray = date.split(delimArray[delimCounter]);
            		if(dateArray.length == 3){
            			break;
            		}
            	}
            	
            	//If it's not a valid date format, use the current date.
                //fixing bug #48823: 
                //'Stack overflow at line : 80' alert displayed when user clicks on the calendar icon 
                if(dateArray.length != 3)
                {
                    var oDate = new Date();
                    var dateArray = [0,0,0];
                    dateArray[dateParams.dayPos] = oDate.getDate();
                    dateArray[dateParams.monthPos] = oDate.getMonth() + 1;
                    dateArray[dateParams.yearPos] = oDate.getFullYear();
                }

            	
            	for(var i = 0; i < dateArray.length; i++){
            		if (dateArray[i] > 32){
            			returnArray[dateParams.yearPos] = dateArray[i];
            			dateCheck += 1;
            		}
            		else if(dateArray[i] <= 12){
            			
            			if((dateParams.monthPos < dateParams.dayPos) && (returnArray[dateParams.monthPos] == '')){
            				returnArray[dateParams.monthPos] = dateArray[i];
            				dateCheck += 100;
            			}
            			else if((dateParams.monthPos > dateParams.dayPos) && (returnArray[dateParams.dayPos] != '')){
            				returnArray[dateParams.monthPos] = dateArray[i];
            				dateCheck += 100;
        				}
            			else if((dateParams.dayPos < dateParams.monthPos) && (returnArray[dateParams.dayPos] == '')){
            				returnArray[dateParams.dayPos] = dateArray[i];
            				dateCheck += 10;
            			}
				        else if((dateParams.dayPos > dateParams.monthPos) && (returnArray[dateParams.monthPos] != '')){
							returnArray[dateParams.dayPos] = dateArray[i];
							dateCheck += 10;
						}
        				 
            		}
            		else if(dateArray[i] > 12 && dateArray[i] < 32){
            			if(returnArray[dateParams.dayPos] != ''){
            				returnArray[dateParams.monthPos] = returnArray[dateParams.dayPos];
            				dateCheck -= 10;
            				dateCheck += 100; 
            			}
            			returnArray[dateParams.dayPos] = dateArray[i];
            			dateCheck += 10;            			
            		}            		
            	}
            	
            	//if we're not 111, that means we didn't find all date parts
            	if(dateCheck != 111){
            		return sanitizeDate("", dateParams);
            	}
            	return returnArray.join(dateParams.delim);
            };
            
            var sanitizedDate = sanitizeDate(Dom.get(inputField).value, dateParams);
            var sanitizedDateArray = sanitizedDate.split(dateParams.delim);
            calendar.cfg.setProperty("selected", sanitizedDate);
            calendar.cfg.setProperty("pageDate", sanitizedDateArray[monthPos] + dateParams.delim + sanitizedDateArray[yearPos]);
                
            calendar.render();
            dialog.show();
        });
    });	
};

/* End of File include/javascript/calendar.js */

(function(){
var JSON = YAHOO.lang.JSON;

SUGAR.quickCompose = {};

SUGAR.quickCompose = function() {
	return {

		parentPanel : null,
		dceMenuPanel : null,
		options: null,
		loadingMessgPanl : null,
		frameLoaded : false,
		resourcesLoaded: false,
		tinyLoaded : false,

		/**
		 * Get the required compose package in an ajax call required for
		 * the quick compose.
		 * @method initComposePackage
		 * @param {Array} c Options containing compose package and full return url.
		 * @return {} none
		 **/
		initComposePackage: function(c)
		{
		    //Init fix for YUI 2.7.0 datatable sort.
	        SUGAR.email2.addressBook.initFixForDatatableSort();

		    //JS resources must have been loaded if we reach this step.
		    SUGAR.quickCompose.resourcesLoaded = true;
            var callback =
	        {
	           success: function(o)
	           {
	               var responseData = JSON.parse(o.responseText);
	               //Create and insert the necessary script tag
	               var scriptTag = document.createElement('script');
	               scriptTag.id = 'quickComposeScript';
                   scriptTag.setAttribute('type','text/javascript');

                   if(YAHOO.env.ua.ie > 0) //IE hack
                   		scriptTag.text = responseData.jsData;
                   else  //Everybody else
                   		scriptTag.appendChild(document.createTextNode(responseData.jsData));

                   document.getElementsByTagName("head")[0].appendChild(scriptTag);

                   //Create and insert the necessary div elements and html markup
	               var divTag = document.createElement("div");
	               divTag.innerHTML = responseData.divData;
	               divTag.id = 'quickCompose';
	               YAHOO.util.Dom.insertAfter(divTag, 'content');

	               //Set the flag that we loaded the compose package.
	               SUGAR.quickCompose.frameLoaded = true;
	               //Init the UI
                   SUGAR.quickCompose.initUI(c.data);
	           }
	       }

	       if(!SUGAR.quickCompose.frameLoaded)
		      YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=GenerateQuickComposeFrame', callback, null);
		   else
		      SUGAR.quickCompose.initUI(c.data);

		},
		/**
		 * Initalize the UI for the quick compose
		 * the quick compose.
		 * @method initComposePackage
		 * @param {Array} options Options containing compose package and full return url.
		 * @return {} none
		 **/
		initUI: function(options)
		{
			var SQ = SUGAR.quickCompose;
			this.options = options;

			//Hide the loading div
			loadingMessgPanl.hide();

    		var dce_mode = (typeof this.dceMenuPanel != 'undefined' && this.dceMenuPanel != null) ? true : false;

			//Destroy the previous quick compose panel to get a clean slate
    		if (SQ.parentPanel != null)
    		{
    			//First clean up the tinyMCE instance
    			tinyMCE.execCommand('mceRemoveControl', false, SUGAR.email2.tinyInstances.currentHtmleditor);
    			SUGAR.email2.tinyInstances[SUGAR.email2.tinyInstances.currentHtmleditor] = null;
    			SUGAR.email2.tinyInstances.currentHtmleditor = "";
    			SQ.parentPanel.destroy();
    			SQ.parentPanel = null;
    		}

			var theme = SUGAR.themes.theme_name;

			//The quick compose utalizes the EmailUI compose functionality which allows for multiple compose
			//tabs.  Quick compose always has only one compose screen with an index of 0.
			var idx = 0;

		    //Get template engine with template
    		if (!SE.composeLayout.composeTemplate)
    			SE.composeLayout.composeTemplate = new YAHOO.SUGAR.Template(SE.templates['compose']);

    		var panel_modal = dce_mode ? false : true,
    		    panel_width = '880px',
			    panel_constrain = dce_mode ? false : true,
    		    panel_height = dce_mode ? 'auto' : '400px',
    		    panel_shadow = dce_mode ? false : true,
    		    panel_draggable = dce_mode ? false : true,
    		    panel_resize = dce_mode ? false : true,
    		    panel_close = dce_mode ? false : true;

        	SQ.parentPanel = new YAHOO.widget.Panel("container1", {
                modal: panel_modal,
				visible: true,
            	constraintoviewport: panel_constrain,
                width	: panel_width,
                height : panel_height,
                shadow	: panel_shadow,
                draggable : panel_draggable,
				resize: panel_resize,
				close: panel_close
            });

        	if(!dce_mode) {
        		SQ.parentPanel.setHeader( SUGAR.language.get('app_strings','LBL_EMAIL_QUICK_COMPOSE')) ;
        	}

            SQ.parentPanel.setBody("<div class='email'><div id='htmleditordiv" + idx + "'></div></div>");

			var composePanel = SE.composeLayout.getQuickComposeLayout(SQ.parentPanel,this.options);

			if(!dce_mode) {
				var resize = new YAHOO.util.Resize('container1', {
                    handles: ['br'],
                    autoRatio: false,
                    minWidth: 400,
                    minHeight: 350,
                    status: false
                });

                resize.on('resize', function(args) {
                    var panelHeight = args.height;
                    this.cfg.setProperty("height", panelHeight + "px");
					var layout = SE.composeLayout[SE.composeLayout.currentInstanceId];
					layout.set("height", panelHeight - 50);
					layout.resize(true);
					SE.composeLayout.resizeEditor(SE.composeLayout.currentInstanceId);
                }, SQ.parentPanel, true);
			} else {
                SUGAR.util.doWhen("typeof SE.composeLayout[SE.composeLayout.currentInstanceId] != 'undefined'", function(){
                    var panelHeight = 400;
                    SQ.parentPanel.cfg.setProperty("height", panelHeight + "px");
                    var layout = SE.composeLayout[SE.composeLayout.currentInstanceId];
                    layout.set("height", panelHeight);
                    layout.resize(true);
                    SE.composeLayout.resizeEditor(SE.composeLayout.currentInstanceId);
                });
            }

			YAHOO.util.Dom.setStyle("container1", "z-index", 1);

			if (!SQ.tinyLoaded)
			{
				//TinyMCE bug, since we are loading the js file dynamically we need to let tiny know that the
				//dom event has fired.
				tinymce.dom.Event.domLoaded = true;

				tinyMCE.init({
			 		 convert_urls : false,
			         theme_advanced_toolbar_align : tinyConfig.theme_advanced_toolbar_align,
                     valid_children : tinyConfig.valid_children,
			         width: tinyConfig.width,
			         theme: tinyConfig.theme,
			         theme_advanced_toolbar_location : tinyConfig.theme_advanced_toolbar_location,
			         theme_advanced_buttons1 : tinyConfig.theme_advanced_buttons1,
			         theme_advanced_buttons2 : tinyConfig.theme_advanced_buttons2,
			         theme_advanced_buttons3 : tinyConfig.theme_advanced_buttons3,
			         plugins : tinyConfig.plugins,
			         elements : tinyConfig.elements,
			         language : tinyConfig.language,
			         extended_valid_elements : tinyConfig.extended_valid_elements,
			         mode: tinyConfig.mode,
			         strict_loading_mode : true
		    	 });
				SQ.tinyLoaded = true;
			}

			SQ.parentPanel.show();

			//Re-declare the close function to handle appropriattely.
			SUGAR.email2.composeLayout.forceCloseCompose = function(o){SUGAR.quickCompose.parentPanel.hide(); }



			if(!dce_mode) {
				SQ.parentPanel.center();
			}
		},
		/**
		 * Display a loading pannel and start retrieving the quick compose requirements.
		 * @method init
		 * @param {Array} o Options containing compose package and full return url.
		 * @return {} none
		 **/
		init: function(o) {

			  if(typeof o.menu_id != 'undefined') {
			     this.dceMenuPanel = o.menu_id;
			  } else {
			     this.dceMenuPanel = null;
			  }

              loadingMessgPanl = new YAHOO.widget.SimpleDialog('loading', {
        			width: '200px',
        			close: true,
        			modal: true,
        			visible:  true,
        			fixedcenter: true,
        	        constraintoviewport: true,
        	        draggable: false
		      });

              loadingMessgPanl.setHeader(SUGAR.language.get('app_strings','LBL_EMAIL_PERFORMING_TASK'));
		      loadingMessgPanl.setBody(SUGAR.language.get('app_strings','LBL_EMAIL_ONE_MOMENT'));
		      loadingMessgPanl.render(document.body);
		      loadingMessgPanl.show();

		      //If JS files havn't been loaded, perform the load.
		      if(! SUGAR.quickCompose.resourcesLoaded )
		          this.loadResources(o);
		      else
		          this.initUI(o);
		},
		/**
		 * Pull in all the required js files.
		 * @method loadResources
		 * @param {Array} o Options containing compose package and full return url.
		 * @return {} none
		 **/
		loadResources: function(o)
		{
			//IE Bug fix for TinyMCE when pulling in the js file dynamically.
		   	window.skipTinyMCEInitPhase = true;
		    var require = ["layout", "element", "tabview", "menu","cookie","tinymce","sugarwidgets","sugarquickcompose","sugarquickcomposecss"];
			var loader = new YAHOO.util.YUILoader({
				    require : require,
				    loadOptional: true,
				    skin: { base: 'blank', defaultSkin: '' },
				    data: o,
				    onSuccess: this.initComposePackage,
				    allowRollup: true,
				    base: "include/javascript/yui/build/"
				});

				//TiinyMCE cannot be added into the sugar_grp_quickcomp file as it breaks the build, needs to be loaded
				//separately.
				loader.addModule({
				    name :"tinymce",
				    type : "js",
				    varName: "TinyMCE",
                    fullpath: "include/javascript/tiny_mce/tiny_mce.js?v=" + (SUGAR.VERSION_MARK || "")
				});

				//Load the Sugar widgets with dependancies on the yui library.
				loader.addModule({
				    name :"sugarwidgets",
				    type : "js",
                    fullpath: "include/javascript/sugarwidgets/SugarYUIWidgets.js?v=" + (SUGAR.VERSION_MARK || ""),
				    varName: "YAHOO.SUGAR",
				    requires: ["datatable", "dragdrop", "treeview", "tabview"]
				});

				//Load the main components for the quick create compose screen.
				loader.addModule({
				    name :"sugarquickcompose",
				    type : "js",
				    varName: "SUGAR.email2.complexLayout",
				    requires: ["layout", "sugarwidgets", "tinymce"],
                    fullpath: "cache/include/javascript/sugar_grp_quickcomp.js?v=" + (SUGAR.VERSION_MARK || "")
				});

				//Load the css needed for the quickCompose.
				loader.addModule({
				    name :"sugarquickcomposecss",
				    type : "css",
                    fullpath: "modules/Emails/EmailUI.css?v=" + (SUGAR.VERSION_MARK || "")
				});

				loader.insert();
	    }
	};
}();
})();

/* End of File include/javascript/quickCompose.js */

/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
if(typeof YAHOO=="undefined"||!YAHOO){var YAHOO={};}YAHOO.namespace=function(){var b=arguments,g=null,e,c,f;for(e=0;e<b.length;e=e+1){f=(""+b[e]).split(".");g=YAHOO;for(c=(f[0]=="YAHOO")?1:0;c<f.length;c=c+1){g[f[c]]=g[f[c]]||{};g=g[f[c]];}}return g;};YAHOO.log=function(d,a,c){var b=YAHOO.widget.Logger;if(b&&b.log){return b.log(d,a,c);}else{return false;}};YAHOO.register=function(a,f,e){var k=YAHOO.env.modules,c,j,h,g,d;if(!k[a]){k[a]={versions:[],builds:[]};}c=k[a];j=e.version;h=e.build;g=YAHOO.env.listeners;c.name=a;c.version=j;c.build=h;c.versions.push(j);c.builds.push(h);c.mainClass=f;for(d=0;d<g.length;d=d+1){g[d](c);}if(f){f.VERSION=j;f.BUILD=h;}else{YAHOO.log("mainClass is undefined for module "+a,"warn");}};YAHOO.env=YAHOO.env||{modules:[],listeners:[]};YAHOO.env.getVersion=function(a){return YAHOO.env.modules[a]||null;};YAHOO.env.parseUA=function(d){var e=function(i){var j=0;return parseFloat(i.replace(/\./g,function(){return(j++==1)?"":".";}));},h=navigator,g={ie:0,opera:0,gecko:0,webkit:0,chrome:0,mobile:null,air:0,ipad:0,iphone:0,ipod:0,ios:null,android:0,webos:0,caja:h&&h.cajaVersion,secure:false,os:null},c=d||(navigator&&navigator.userAgent),f=window&&window.location,b=f&&f.href,a;g.secure=b&&(b.toLowerCase().indexOf("https")===0);if(c){if((/windows|win32/i).test(c)){g.os="windows";}else{if((/macintosh/i).test(c)){g.os="macintosh";}else{if((/rhino/i).test(c)){g.os="rhino";}}}if((/KHTML/).test(c)){g.webkit=1;}a=c.match(/AppleWebKit\/([^\s]*)/);if(a&&a[1]){g.webkit=e(a[1]);if(/ Mobile\//.test(c)){g.mobile="Apple";a=c.match(/OS ([^\s]*)/);if(a&&a[1]){a=e(a[1].replace("_","."));}g.ios=a;g.ipad=g.ipod=g.iphone=0;a=c.match(/iPad|iPod|iPhone/);if(a&&a[0]){g[a[0].toLowerCase()]=g.ios;}}else{a=c.match(/NokiaN[^\/]*|Android \d\.\d|webOS\/\d\.\d/);if(a){g.mobile=a[0];}if(/webOS/.test(c)){g.mobile="WebOS";a=c.match(/webOS\/([^\s]*);/);if(a&&a[1]){g.webos=e(a[1]);}}if(/ Android/.test(c)){g.mobile="Android";a=c.match(/Android ([^\s]*);/);if(a&&a[1]){g.android=e(a[1]);}}}a=c.match(/Chrome\/([^\s]*)/);if(a&&a[1]){g.chrome=e(a[1]);}else{a=c.match(/AdobeAIR\/([^\s]*)/);if(a){g.air=a[0];}}}if(!g.webkit){a=c.match(/Opera[\s\/]([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);a=c.match(/Version\/([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);}a=c.match(/Opera Mini[^;]*/);if(a){g.mobile=a[0];}}else{a=c.match(/MSIE\s([^;]*)/);if(a&&a[1]){g.ie=e(a[1]);}else{a=c.match(/Gecko\/([^\s]*)/);if(a){g.gecko=1;a=c.match(/rv:([^\s\)]*)/);if(a&&a[1]){g.gecko=e(a[1]);}}}}}}return g;};YAHOO.env.ua=YAHOO.env.parseUA();(function(){YAHOO.namespace("util","widget","example");if("undefined"!==typeof YAHOO_config){var b=YAHOO_config.listener,a=YAHOO.env.listeners,d=true,c;if(b){for(c=0;c<a.length;c++){if(a[c]==b){d=false;break;}}if(d){a.push(b);}}}})();YAHOO.lang=YAHOO.lang||{};(function(){var f=YAHOO.lang,a=Object.prototype,c="[object Array]",h="[object Function]",i="[object Object]",b=[],g={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","/":"&#x2F;","`":"&#x60;"},d=["toString","valueOf"],e={isArray:function(j){return a.toString.apply(j)===c;},isBoolean:function(j){return typeof j==="boolean";},isFunction:function(j){return(typeof j==="function")||a.toString.apply(j)===h;},isNull:function(j){return j===null;},isNumber:function(j){return typeof j==="number"&&isFinite(j);},isObject:function(j){return(j&&(typeof j==="object"||f.isFunction(j)))||false;},isString:function(j){return typeof j==="string";},isUndefined:function(j){return typeof j==="undefined";},_IEEnumFix:(YAHOO.env.ua.ie)?function(l,k){var j,n,m;for(j=0;j<d.length;j=j+1){n=d[j];m=k[n];if(f.isFunction(m)&&m!=a[n]){l[n]=m;}}}:function(){},escapeHTML:function(j){return j.replace(/[&<>"'\/`]/g,function(k){return g[k];});},extend:function(m,n,l){if(!n||!m){throw new Error("extend failed, please check that "+"all dependencies are included.");}var k=function(){},j;k.prototype=n.prototype;m.prototype=new k();m.prototype.constructor=m;m.superclass=n.prototype;if(n.prototype.constructor==a.constructor){n.prototype.constructor=n;}if(l){for(j in l){if(f.hasOwnProperty(l,j)){m.prototype[j]=l[j];}}f._IEEnumFix(m.prototype,l);}},augmentObject:function(n,m){if(!m||!n){throw new Error("Absorb failed, verify dependencies.");}var j=arguments,l,o,k=j[2];if(k&&k!==true){for(l=2;l<j.length;l=l+1){n[j[l]]=m[j[l]];}}else{for(o in m){if(k||!(o in n)){n[o]=m[o];}}f._IEEnumFix(n,m);}return n;},augmentProto:function(m,l){if(!l||!m){throw new Error("Augment failed, verify dependencies.");}var j=[m.prototype,l.prototype],k;for(k=2;k<arguments.length;k=k+1){j.push(arguments[k]);}f.augmentObject.apply(this,j);return m;},dump:function(j,p){var l,n,r=[],t="{...}",k="f(){...}",q=", ",m=" => ";if(!f.isObject(j)){return j+"";}else{if(j instanceof Date||("nodeType" in j&&"tagName" in j)){return j;}else{if(f.isFunction(j)){return k;}}}p=(f.isNumber(p))?p:3;if(f.isArray(j)){r.push("[");for(l=0,n=j.length;l<n;l=l+1){if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}if(r.length>1){r.pop();}r.push("]");}else{r.push("{");for(l in j){if(f.hasOwnProperty(j,l)){r.push(l+m);if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}}if(r.length>1){r.pop();}r.push("}");}return r.join("");},substitute:function(x,y,E,l){var D,C,B,G,t,u,F=[],p,z=x.length,A="dump",r=" ",q="{",m="}",n,w;for(;;){D=x.lastIndexOf(q,z);if(D<0){break;}C=x.indexOf(m,D);if(D+1>C){break;}p=x.substring(D+1,C);G=p;u=null;B=G.indexOf(r);if(B>-1){u=G.substring(B+1);G=G.substring(0,B);}t=y[G];if(E){t=E(G,t,u);}if(f.isObject(t)){if(f.isArray(t)){t=f.dump(t,parseInt(u,10));}else{u=u||"";n=u.indexOf(A);if(n>-1){u=u.substring(4);}w=t.toString();if(w===i||n>-1){t=f.dump(t,parseInt(u,10));}else{t=w;}}}else{if(!f.isString(t)&&!f.isNumber(t)){t="~-"+F.length+"-~";F[F.length]=p;}}x=x.substring(0,D)+t+x.substring(C+1);if(l===false){z=D-1;}}for(D=F.length-1;D>=0;D=D-1){x=x.replace(new RegExp("~-"+D+"-~"),"{"+F[D]+"}","g");}return x;},trim:function(j){try{return j.replace(/^\s+|\s+$/g,"");}catch(k){return j;
}},merge:function(){var n={},k=arguments,j=k.length,m;for(m=0;m<j;m=m+1){f.augmentObject(n,k[m],true);}return n;},later:function(t,k,u,n,p){t=t||0;k=k||{};var l=u,s=n,q,j;if(f.isString(u)){l=k[u];}if(!l){throw new TypeError("method undefined");}if(!f.isUndefined(n)&&!f.isArray(s)){s=[n];}q=function(){l.apply(k,s||b);};j=(p)?setInterval(q,t):setTimeout(q,t);return{interval:p,cancel:function(){if(this.interval){clearInterval(j);}else{clearTimeout(j);}}};},isValue:function(j){return(f.isObject(j)||f.isString(j)||f.isNumber(j)||f.isBoolean(j));}};f.hasOwnProperty=(a.hasOwnProperty)?function(j,k){return j&&j.hasOwnProperty&&j.hasOwnProperty(k);}:function(j,k){return !f.isUndefined(j[k])&&j.constructor.prototype[k]!==j[k];};e.augmentObject(f,e,true);YAHOO.util.Lang=f;f.augment=f.augmentProto;YAHOO.augment=f.augmentProto;YAHOO.extend=f.extend;})();YAHOO.register("yahoo",YAHOO,{version:"2.9.0",build:"2800"});YAHOO.util.Get=function(){var m={},k=0,r=0,l=false,n=YAHOO.env.ua,s=YAHOO.lang,q,d,e,i=function(x,t,y){var u=y||window,z=u.document,A=z.createElement(x),v;for(v in t){if(t.hasOwnProperty(v)){A.setAttribute(v,t[v]);}}return A;},h=function(u,v,t){var w={id:"yui__dyn_"+(r++),type:"text/css",rel:"stylesheet",href:u};if(t){s.augmentObject(w,t);}return i("link",w,v);},p=function(u,v,t){var w={id:"yui__dyn_"+(r++),type:"text/javascript",src:u};if(t){s.augmentObject(w,t);}return i("script",w,v);},a=function(t,u){return{tId:t.tId,win:t.win,data:t.data,nodes:t.nodes,msg:u,purge:function(){d(this.tId);}};},b=function(t,w){var u=m[w],v=(s.isString(t))?u.win.document.getElementById(t):t;if(!v){q(w,"target node not found: "+t);}return v;},c=function(w){YAHOO.log("Finishing transaction "+w);var u=m[w],v,t;u.finished=true;if(u.aborted){v="transaction "+w+" was aborted";q(w,v);return;}if(u.onSuccess){t=u.scope||u.win;u.onSuccess.call(t,a(u));}},o=function(v){YAHOO.log("Timeout "+v,"info","get");var u=m[v],t;if(u.onTimeout){t=u.scope||u;u.onTimeout.call(t,a(u));}},f=function(v,A){YAHOO.log("_next: "+v+", loaded: "+A,"info","Get");var u=m[v],D=u.win,C=D.document,B=C.getElementsByTagName("head")[0],x,y,t,E,z;if(u.timer){u.timer.cancel();}if(u.aborted){y="transaction "+v+" was aborted";q(v,y);return;}if(A){u.url.shift();if(u.varName){u.varName.shift();}}else{u.url=(s.isString(u.url))?[u.url]:u.url;if(u.varName){u.varName=(s.isString(u.varName))?[u.varName]:u.varName;}}if(u.url.length===0){if(u.type==="script"&&n.webkit&&n.webkit<420&&!u.finalpass&&!u.varName){z=p(null,u.win,u.attributes);z.innerHTML='YAHOO.util.Get._finalize("'+v+'");';u.nodes.push(z);B.appendChild(z);}else{c(v);}return;}t=u.url[0];if(!t){u.url.shift();YAHOO.log("skipping empty url");return f(v);}YAHOO.log("attempting to load "+t,"info","Get");if(u.timeout){u.timer=s.later(u.timeout,u,o,v);}if(u.type==="script"){x=p(t,D,u.attributes);}else{x=h(t,D,u.attributes);}e(u.type,x,v,t,D,u.url.length);u.nodes.push(x);if(u.insertBefore){E=b(u.insertBefore,v);if(E){E.parentNode.insertBefore(x,E);}}else{B.appendChild(x);}YAHOO.log("Appending node: "+t,"info","Get");if((n.webkit||n.gecko)&&u.type==="css"){f(v,t);}},j=function(){if(l){return;}l=true;var t,u;for(t in m){if(m.hasOwnProperty(t)){u=m[t];if(u.autopurge&&u.finished){d(u.tId);delete m[t];}}}l=false;},g=function(u,t,v){var x="q"+(k++),w;v=v||{};if(k%YAHOO.util.Get.PURGE_THRESH===0){j();}m[x]=s.merge(v,{tId:x,type:u,url:t,finished:false,aborted:false,nodes:[]});w=m[x];w.win=w.win||window;w.scope=w.scope||w.win;w.autopurge=("autopurge" in w)?w.autopurge:(u==="script")?true:false;w.attributes=w.attributes||{};w.attributes.charset=v.charset||w.attributes.charset||"utf-8";s.later(0,w,f,x);return{tId:x};};e=function(H,z,x,u,D,E,G){var F=G||f,B,t,I,v,J,A,C,y;if(n.ie){z.onreadystatechange=function(){B=this.readyState;if("loaded"===B||"complete"===B){YAHOO.log(x+" onload "+u,"info","Get");z.onreadystatechange=null;F(x,u);}};}else{if(n.webkit){if(H==="script"){if(n.webkit>=420){z.addEventListener("load",function(){YAHOO.log(x+" DOM2 onload "+u,"info","Get");F(x,u);});}else{t=m[x];if(t.varName){v=YAHOO.util.Get.POLL_FREQ;YAHOO.log("Polling for "+t.varName[0]);t.maxattempts=YAHOO.util.Get.TIMEOUT/v;t.attempts=0;t._cache=t.varName[0].split(".");t.timer=s.later(v,t,function(w){I=this._cache;A=I.length;J=this.win;for(C=0;C<A;C=C+1){J=J[I[C]];if(!J){this.attempts++;if(this.attempts++>this.maxattempts){y="Over retry limit, giving up";t.timer.cancel();q(x,y);}else{YAHOO.log(I[C]+" failed, retrying");}return;}}YAHOO.log("Safari poll complete");t.timer.cancel();F(x,u);},null,true);}else{s.later(YAHOO.util.Get.POLL_FREQ,null,F,[x,u]);}}}}else{z.onload=function(){YAHOO.log(x+" onload "+u,"info","Get");F(x,u);};}}};q=function(w,v){YAHOO.log("get failure: "+v,"warn","Get");var u=m[w],t;if(u.onFailure){t=u.scope||u.win;u.onFailure.call(t,a(u,v));}};d=function(z){if(m[z]){var t=m[z],u=t.nodes,x=u.length,C=t.win.document,A=C.getElementsByTagName("head")[0],v,y,w,B;if(t.insertBefore){v=b(t.insertBefore,z);if(v){A=v.parentNode;}}for(y=0;y<x;y=y+1){w=u[y];if(w.clearAttributes){w.clearAttributes();}else{for(B in w){if(w.hasOwnProperty(B)){delete w[B];}}}A.removeChild(w);}t.nodes=[];}};return{POLL_FREQ:10,PURGE_THRESH:20,TIMEOUT:2000,_finalize:function(t){YAHOO.log(t+" finalized ","info","Get");s.later(0,null,c,t);},abort:function(u){var v=(s.isString(u))?u:u.tId,t=m[v];if(t){YAHOO.log("Aborting "+v,"info","Get");t.aborted=true;}},script:function(t,u){return g("script",t,u);},css:function(t,u){return g("css",t,u);}};}();YAHOO.register("get",YAHOO.util.Get,{version:"2.9.0",build:"2800"});(function(){var Y=YAHOO,util=Y.util,lang=Y.lang,env=Y.env,PROV="_provides",SUPER="_supersedes",REQ="expanded",AFTER="_after",VERSION="2.9.0";var YUI={dupsAllowed:{"yahoo":true,"get":true},info:{"root":VERSION+"/build/","base":"http://yui.yahooapis.com/"+VERSION+"/build/","comboBase":"http://yui.yahooapis.com/combo?","skin":{"defaultSkin":"sam","base":"assets/skins/","path":"skin.css","after":["reset","fonts","grids","base"],"rollup":3},dupsAllowed:["yahoo","get"],"moduleInfo":{"animation":{"type":"js","path":"animation/animation-min.js","requires":["dom","event"]},"autocomplete":{"type":"js","path":"autocomplete/autocomplete-min.js","requires":["dom","event","datasource"],"optional":["connection","animation"],"skinnable":true},"base":{"type":"css","path":"base/base-min.css","after":["reset","fonts","grids"]},"button":{"type":"js","path":"button/button-min.js","requires":["element"],"optional":["menu"],"skinnable":true},"calendar":{"type":"js","path":"calendar/calendar-min.js","requires":["event","dom"],supersedes:["datemath"],"skinnable":true},"carousel":{"type":"js","path":"carousel/carousel-min.js","requires":["element"],"optional":["animation"],"skinnable":true},"charts":{"type":"js","path":"charts/charts-min.js","requires":["element","json","datasource","swf"]},"colorpicker":{"type":"js","path":"colorpicker/colorpicker-min.js","requires":["slider","element"],"optional":["animation"],"skinnable":true},"connection":{"type":"js","path":"connection/connection-min.js","requires":["event"],"supersedes":["connectioncore"]},"connectioncore":{"type":"js","path":"connection/connection_core-min.js","requires":["event"],"pkg":"connection"},"container":{"type":"js","path":"container/container-min.js","requires":["dom","event"],"optional":["dragdrop","animation","connection"],"supersedes":["containercore"],"skinnable":true},"containercore":{"type":"js","path":"container/container_core-min.js","requires":["dom","event"],"pkg":"container"},"cookie":{"type":"js","path":"cookie/cookie-min.js","requires":["yahoo"]},"datasource":{"type":"js","path":"datasource/datasource-min.js","requires":["event"],"optional":["connection"]},"datatable":{"type":"js","path":"datatable/datatable-min.js","requires":["element","datasource"],"optional":["calendar","dragdrop","paginator"],"skinnable":true},datemath:{"type":"js","path":"datemath/datemath-min.js","requires":["yahoo"]},"dom":{"type":"js","path":"dom/dom-min.js","requires":["yahoo"]},"dragdrop":{"type":"js","path":"dragdrop/dragdrop-min.js","requires":["dom","event"]},"editor":{"type":"js","path":"editor/editor-min.js","requires":["menu","element","button"],"optional":["animation","dragdrop"],"supersedes":["simpleeditor"],"skinnable":true},"element":{"type":"js","path":"element/element-min.js","requires":["dom","event"],"optional":["event-mouseenter","event-delegate"]},"element-delegate":{"type":"js","path":"element-delegate/element-delegate-min.js","requires":["element"]},"event":{"type":"js","path":"event/event-min.js","requires":["yahoo"]},"event-simulate":{"type":"js","path":"event-simulate/event-simulate-min.js","requires":["event"]},"event-delegate":{"type":"js","path":"event-delegate/event-delegate-min.js","requires":["event"],"optional":["selector"]},"event-mouseenter":{"type":"js","path":"event-mouseenter/event-mouseenter-min.js","requires":["dom","event"]},"fonts":{"type":"css","path":"fonts/fonts-min.css"},"get":{"type":"js","path":"get/get-min.js","requires":["yahoo"]},"grids":{"type":"css","path":"grids/grids-min.css","requires":["fonts"],"optional":["reset"]},"history":{"type":"js","path":"history/history-min.js","requires":["event"]},"imagecropper":{"type":"js","path":"imagecropper/imagecropper-min.js","requires":["dragdrop","element","resize"],"skinnable":true},"imageloader":{"type":"js","path":"imageloader/imageloader-min.js","requires":["event","dom"]},"json":{"type":"js","path":"json/json-min.js","requires":["yahoo"]},"layout":{"type":"js","path":"layout/layout-min.js","requires":["element"],"optional":["animation","dragdrop","resize","selector"],"skinnable":true},"logger":{"type":"js","path":"logger/logger-min.js","requires":["event","dom"],"optional":["dragdrop"],"skinnable":true},"menu":{"type":"js","path":"menu/menu-min.js","requires":["containercore"],"skinnable":true},"paginator":{"type":"js","path":"paginator/paginator-min.js","requires":["element"],"skinnable":true},"profiler":{"type":"js","path":"profiler/profiler-min.js","requires":["yahoo"]},"profilerviewer":{"type":"js","path":"profilerviewer/profilerviewer-min.js","requires":["profiler","yuiloader","element"],"skinnable":true},"progressbar":{"type":"js","path":"progressbar/progressbar-min.js","requires":["element"],"optional":["animation"],"skinnable":true},"reset":{"type":"css","path":"reset/reset-min.css"},"reset-fonts-grids":{"type":"css","path":"reset-fonts-grids/reset-fonts-grids.css","supersedes":["reset","fonts","grids","reset-fonts"],"rollup":4},"reset-fonts":{"type":"css","path":"reset-fonts/reset-fonts.css","supersedes":["reset","fonts"],"rollup":2},"resize":{"type":"js","path":"resize/resize-min.js","requires":["dragdrop","element"],"optional":["animation"],"skinnable":true},"selector":{"type":"js","path":"selector/selector-min.js","requires":["yahoo","dom"]},"simpleeditor":{"type":"js","path":"editor/simpleeditor-min.js","requires":["element"],"optional":["containercore","menu","button","animation","dragdrop"],"skinnable":true,"pkg":"editor"},"slider":{"type":"js","path":"slider/slider-min.js","requires":["dragdrop"],"optional":["animation"],"skinnable":true},"storage":{"type":"js","path":"storage/storage-min.js","requires":["yahoo","event","cookie"],"optional":["swfstore"]},"stylesheet":{"type":"js","path":"stylesheet/stylesheet-min.js","requires":["yahoo"]},"swf":{"type":"js","path":"swf/swf-min.js","requires":["element"],"supersedes":["swfdetect"]},"swfdetect":{"type":"js","path":"swfdetect/swfdetect-min.js","requires":["yahoo"]},"swfstore":{"type":"js","path":"swfstore/swfstore-min.js","requires":["element","cookie","swf"]},"tabview":{"type":"js","path":"tabview/tabview-min.js","requires":["element"],"optional":["connection"],"skinnable":true},"treeview":{"type":"js","path":"treeview/treeview-min.js","requires":["event","dom"],"optional":["json","animation","calendar"],"skinnable":true},"uploader":{"type":"js","path":"uploader/uploader-min.js","requires":["element"]},"utilities":{"type":"js","path":"utilities/utilities.js","supersedes":["yahoo","event","dragdrop","animation","dom","connection","element","yahoo-dom-event","get","yuiloader","yuiloader-dom-event"],"rollup":8},"yahoo":{"type":"js","path":"yahoo/yahoo-min.js"},"yahoo-dom-event":{"type":"js","path":"yahoo-dom-event/yahoo-dom-event.js","supersedes":["yahoo","event","dom"],"rollup":3},"yuiloader":{"type":"js","path":"yuiloader/yuiloader-min.js","supersedes":["yahoo","get"]},"yuiloader-dom-event":{"type":"js","path":"yuiloader-dom-event/yuiloader-dom-event.js","supersedes":["yahoo","dom","event","get","yuiloader","yahoo-dom-event"],"rollup":5},"yuitest":{"type":"js","path":"yuitest/yuitest-min.js","requires":["logger"],"optional":["event-simulate"],"skinnable":true}}},ObjectUtil:{appendArray:function(o,a){if(a){for(var i=0;
i<a.length;i=i+1){o[a[i]]=true;}}},keys:function(o,ordered){var a=[],i;for(i in o){if(lang.hasOwnProperty(o,i)){a.push(i);}}return a;}},ArrayUtil:{appendArray:function(a1,a2){Array.prototype.push.apply(a1,a2);},indexOf:function(a,val){for(var i=0;i<a.length;i=i+1){if(a[i]===val){return i;}}return -1;},toObject:function(a){var o={};for(var i=0;i<a.length;i=i+1){o[a[i]]=true;}return o;},uniq:function(a){return YUI.ObjectUtil.keys(YUI.ArrayUtil.toObject(a));}}};YAHOO.util.YUILoader=function(o){this._internalCallback=null;this._useYahooListener=false;this.onSuccess=null;this.onFailure=Y.log;this.onProgress=null;this.onTimeout=null;this.scope=this;this.data=null;this.insertBefore=null;this.charset=null;this.varName=null;this.base=YUI.info.base;this.comboBase=YUI.info.comboBase;this.combine=false;this.root=YUI.info.root;this.timeout=0;this.ignore=null;this.force=null;this.allowRollup=true;this.filter=null;this.required={};this.moduleInfo=lang.merge(YUI.info.moduleInfo);this.rollups=null;this.loadOptional=false;this.sorted=[];this.loaded={};this.dirty=true;this.inserted={};var self=this;env.listeners.push(function(m){if(self._useYahooListener){self.loadNext(m.name);}});this.skin=lang.merge(YUI.info.skin);this._config(o);};Y.util.YUILoader.prototype={FILTERS:{RAW:{"searchExp":"-min\\.js","replaceStr":".js"},DEBUG:{"searchExp":"-min\\.js","replaceStr":"-debug.js"}},SKIN_PREFIX:"skin-",_config:function(o){if(o){for(var i in o){if(lang.hasOwnProperty(o,i)){if(i=="require"){this.require(o[i]);}else{this[i]=o[i];}}}}var f=this.filter;if(lang.isString(f)){f=f.toUpperCase();if(f==="DEBUG"){this.require("logger");}if(!Y.widget.LogWriter){Y.widget.LogWriter=function(){return Y;};}this.filter=this.FILTERS[f];}},addModule:function(o){if(!o||!o.name||!o.type||(!o.path&&!o.fullpath)){return false;}o.ext=("ext" in o)?o.ext:true;o.requires=o.requires||[];this.moduleInfo[o.name]=o;this.dirty=true;return true;},require:function(what){var a=(typeof what==="string")?arguments:what;this.dirty=true;YUI.ObjectUtil.appendArray(this.required,a);},_addSkin:function(skin,mod){var name=this.formatSkin(skin),info=this.moduleInfo,sinf=this.skin,ext=info[mod]&&info[mod].ext;if(!info[name]){this.addModule({"name":name,"type":"css","path":sinf.base+skin+"/"+sinf.path,"after":sinf.after,"rollup":sinf.rollup,"ext":ext});}if(mod){name=this.formatSkin(skin,mod);if(!info[name]){var mdef=info[mod],pkg=mdef.pkg||mod;this.addModule({"name":name,"type":"css","after":sinf.after,"path":pkg+"/"+sinf.base+skin+"/"+mod+".css","ext":ext});}}return name;},getRequires:function(mod){if(!mod){return[];}if(!this.dirty&&mod.expanded){return mod.expanded;}mod.requires=mod.requires||[];var i,d=[],r=mod.requires,o=mod.optional,info=this.moduleInfo,m;for(i=0;i<r.length;i=i+1){d.push(r[i]);m=info[r[i]];YUI.ArrayUtil.appendArray(d,this.getRequires(m));}if(o&&this.loadOptional){for(i=0;i<o.length;i=i+1){d.push(o[i]);YUI.ArrayUtil.appendArray(d,this.getRequires(info[o[i]]));}}mod.expanded=YUI.ArrayUtil.uniq(d);return mod.expanded;},getProvides:function(name,notMe){var addMe=!(notMe),ckey=(addMe)?PROV:SUPER,m=this.moduleInfo[name],o={};if(!m){return o;}if(m[ckey]){return m[ckey];}var s=m.supersedes,done={},me=this;var add=function(mm){if(!done[mm]){done[mm]=true;lang.augmentObject(o,me.getProvides(mm));}};if(s){for(var i=0;i<s.length;i=i+1){add(s[i]);}}m[SUPER]=o;m[PROV]=lang.merge(o);m[PROV][name]=true;return m[ckey];},calculate:function(o){if(o||this.dirty){this._config(o);this._setup();this._explode();if(this.allowRollup){this._rollup();}this._reduce();this._sort();this.dirty=false;}},_setup:function(){var info=this.moduleInfo,name,i,j;for(name in info){if(lang.hasOwnProperty(info,name)){var m=info[name];if(m&&m.skinnable){var o=this.skin.overrides,smod;if(o&&o[name]){for(i=0;i<o[name].length;i=i+1){smod=this._addSkin(o[name][i],name);}}else{smod=this._addSkin(this.skin.defaultSkin,name);}if(YUI.ArrayUtil.indexOf(m.requires,smod)==-1){m.requires.push(smod);}}}}var l=lang.merge(this.inserted);if(!this._sandbox){l=lang.merge(l,env.modules);}if(this.ignore){YUI.ObjectUtil.appendArray(l,this.ignore);}if(this.force){for(i=0;i<this.force.length;i=i+1){if(this.force[i] in l){delete l[this.force[i]];}}}for(j in l){if(lang.hasOwnProperty(l,j)){lang.augmentObject(l,this.getProvides(j));}}this.loaded=l;},_explode:function(){var r=this.required,i,mod;for(i in r){if(lang.hasOwnProperty(r,i)){mod=this.moduleInfo[i];if(mod){var req=this.getRequires(mod);if(req){YUI.ObjectUtil.appendArray(r,req);}}}}},_skin:function(){},formatSkin:function(skin,mod){var s=this.SKIN_PREFIX+skin;if(mod){s=s+"-"+mod;}return s;},parseSkin:function(mod){if(mod.indexOf(this.SKIN_PREFIX)===0){var a=mod.split("-");return{skin:a[1],module:a[2]};}return null;},_rollup:function(){var i,j,m,s,rollups={},r=this.required,roll,info=this.moduleInfo;if(this.dirty||!this.rollups){for(i in info){if(lang.hasOwnProperty(info,i)){m=info[i];if(m&&m.rollup){rollups[i]=m;}}}this.rollups=rollups;}for(;;){var rolled=false;for(i in rollups){if(!r[i]&&!this.loaded[i]){m=info[i];s=m.supersedes;roll=false;if(!m.rollup){continue;}var skin=(m.ext)?false:this.parseSkin(i),c=0;if(skin){for(j in r){if(lang.hasOwnProperty(r,j)){if(i!==j&&this.parseSkin(j)){c++;roll=(c>=m.rollup);if(roll){break;}}}}}else{for(j=0;j<s.length;j=j+1){if(this.loaded[s[j]]&&(!YUI.dupsAllowed[s[j]])){roll=false;break;}else{if(r[s[j]]){c++;roll=(c>=m.rollup);if(roll){break;}}}}}if(roll){r[i]=true;rolled=true;this.getRequires(m);}}}if(!rolled){break;}}},_reduce:function(){var i,j,s,m,r=this.required;for(i in r){if(i in this.loaded){delete r[i];}else{var skinDef=this.parseSkin(i);if(skinDef){if(!skinDef.module){var skin_pre=this.SKIN_PREFIX+skinDef.skin;for(j in r){if(lang.hasOwnProperty(r,j)){m=this.moduleInfo[j];var ext=m&&m.ext;if(!ext&&j!==i&&j.indexOf(skin_pre)>-1){delete r[j];}}}}}else{m=this.moduleInfo[i];s=m&&m.supersedes;if(s){for(j=0;j<s.length;j=j+1){if(s[j] in r){delete r[s[j]];}}}}}}},_onFailure:function(msg){YAHOO.log("Failure","info","loader");
var f=this.onFailure;if(f){f.call(this.scope,{msg:"failure: "+msg,data:this.data,success:false});}},_onTimeout:function(){YAHOO.log("Timeout","info","loader");var f=this.onTimeout;if(f){f.call(this.scope,{msg:"timeout",data:this.data,success:false});}},_sort:function(){var s=[],info=this.moduleInfo,loaded=this.loaded,checkOptional=!this.loadOptional,me=this;var requires=function(aa,bb){var mm=info[aa];if(loaded[bb]||!mm){return false;}var ii,rr=mm.expanded,after=mm.after,other=info[bb],optional=mm.optional;if(rr&&YUI.ArrayUtil.indexOf(rr,bb)>-1){return true;}if(after&&YUI.ArrayUtil.indexOf(after,bb)>-1){return true;}if(checkOptional&&optional&&YUI.ArrayUtil.indexOf(optional,bb)>-1){return true;}var ss=info[bb]&&info[bb].supersedes;if(ss){for(ii=0;ii<ss.length;ii=ii+1){if(requires(aa,ss[ii])){return true;}}}if(mm.ext&&mm.type=="css"&&!other.ext&&other.type=="css"){return true;}return false;};for(var i in this.required){if(lang.hasOwnProperty(this.required,i)){s.push(i);}}var p=0;for(;;){var l=s.length,a,b,j,k,moved=false;for(j=p;j<l;j=j+1){a=s[j];for(k=j+1;k<l;k=k+1){if(requires(a,s[k])){b=s.splice(k,1);s.splice(j,0,b[0]);moved=true;break;}}if(moved){break;}else{p=p+1;}}if(!moved){break;}}this.sorted=s;},toString:function(){var o={type:"YUILoader",base:this.base,filter:this.filter,required:this.required,loaded:this.loaded,inserted:this.inserted};lang.dump(o,1);},_combine:function(){this._combining=[];var self=this,s=this.sorted,len=s.length,js=this.comboBase,css=this.comboBase,target,startLen=js.length,i,m,type=this.loadType;YAHOO.log("type "+type);for(i=0;i<len;i=i+1){m=this.moduleInfo[s[i]];if(m&&!m.ext&&(!type||type===m.type)){target=this.root+m.path;target+="&";if(m.type=="js"){js+=target;}else{css+=target;}this._combining.push(s[i]);}}if(this._combining.length){YAHOO.log("Attempting to combine: "+this._combining,"info","loader");var callback=function(o){var c=this._combining,len=c.length,i,m;for(i=0;i<len;i=i+1){this.inserted[c[i]]=true;}this.loadNext(o.data);},loadScript=function(){if(js.length>startLen){YAHOO.util.Get.script(self._filter(js),{data:self._loading,onSuccess:callback,onFailure:self._onFailure,onTimeout:self._onTimeout,insertBefore:self.insertBefore,charset:self.charset,timeout:self.timeout,scope:self});}else{this.loadNext();}};if(css.length>startLen){YAHOO.util.Get.css(this._filter(css),{data:this._loading,onSuccess:loadScript,onFailure:this._onFailure,onTimeout:this._onTimeout,insertBefore:this.insertBefore,charset:this.charset,timeout:this.timeout,scope:self});}else{loadScript();}return;}else{this.loadNext(this._loading);}},insert:function(o,type){this.calculate(o);this._loading=true;this.loadType=type;if(this.combine){return this._combine();}if(!type){var self=this;this._internalCallback=function(){self._internalCallback=null;self.insert(null,"js");};this.insert(null,"css");return;}this.loadNext();},sandbox:function(o,type){var self=this,success=function(o){var idx=o.argument[0],name=o.argument[2];self._scriptText[idx]=o.responseText;if(self.onProgress){self.onProgress.call(self.scope,{name:name,scriptText:o.responseText,xhrResponse:o,data:self.data});}self._loadCount++;if(self._loadCount>=self._stopCount){var v=self.varName||"YAHOO";var t="(function() {\n";var b="\nreturn "+v+";\n})();";var ref=eval(t+self._scriptText.join("\n")+b);self._pushEvents(ref);if(ref){self.onSuccess.call(self.scope,{reference:ref,data:self.data});}else{self._onFailure.call(self.varName+" reference failure");}}},failure=function(o){self.onFailure.call(self.scope,{msg:"XHR failure",xhrResponse:o,data:self.data});};self._config(o);if(!self.onSuccess){throw new Error("You must supply an onSuccess handler for your sandbox");}self._sandbox=true;if(!type||type!=="js"){self._internalCallback=function(){self._internalCallback=null;self.sandbox(null,"js");};self.insert(null,"css");return;}if(!util.Connect){var ld=new YAHOO.util.YUILoader();ld.insert({base:self.base,filter:self.filter,require:"connection",insertBefore:self.insertBefore,charset:self.charset,onSuccess:function(){self.sandbox(null,"js");},scope:self},"js");return;}self._scriptText=[];self._loadCount=0;self._stopCount=self.sorted.length;self._xhr=[];self.calculate();var s=self.sorted,l=s.length,i,m,url;for(i=0;i<l;i=i+1){m=self.moduleInfo[s[i]];if(!m){self._onFailure("undefined module "+m);for(var j=0;j<self._xhr.length;j=j+1){self._xhr[j].abort();}return;}if(m.type!=="js"){self._loadCount++;continue;}url=m.fullpath;url=(url)?self._filter(url):self._url(m.path);var xhrData={success:success,failure:failure,scope:self,argument:[i,url,s[i]]};self._xhr.push(util.Connect.asyncRequest("GET",url,xhrData));}},loadNext:function(mname){if(!this._loading){return;}var self=this,donext=function(o){self.loadNext(o.data);},successfn,s=this.sorted,len=s.length,i,fn,m,url;if(mname){if(mname!==this._loading){return;}this.inserted[mname]=true;if(this.onProgress){this.onProgress.call(this.scope,{name:mname,data:this.data});}}for(i=0;i<len;i=i+1){if(s[i] in this.inserted){continue;}if(s[i]===this._loading){return;}m=this.moduleInfo[s[i]];if(!m){this.onFailure.call(this.scope,{msg:"undefined module "+m,data:this.data});return;}if(!this.loadType||this.loadType===m.type){successfn=donext;this._loading=s[i];fn=(m.type==="css")?util.Get.css:util.Get.script;url=m.fullpath;url=(url)?this._filter(url):this._url(m.path);if(env.ua.webkit&&env.ua.webkit<420&&m.type==="js"&&!m.varName){successfn=null;this._useYahooListener=true;}fn(url,{data:s[i],onSuccess:successfn,onFailure:this._onFailure,onTimeout:this._onTimeout,insertBefore:this.insertBefore,charset:this.charset,timeout:this.timeout,varName:m.varName,scope:self});return;}}this._loading=null;if(this._internalCallback){var f=this._internalCallback;this._internalCallback=null;f.call(this);}else{if(this.onSuccess){this._pushEvents();this.onSuccess.call(this.scope,{data:this.data});}}},_pushEvents:function(ref){var r=ref||YAHOO;if(r.util&&r.util.Event){r.util.Event._load();}},_filter:function(str){var f=this.filter;return(f)?str.replace(new RegExp(f.searchExp,"g"),f.replaceStr):str;
},_url:function(path){return this._filter((this.base||"")+path);}};})();YAHOO.register("yuiloader",YAHOO.util.YUILoader,{version:"2.9.0",build:"2800"});
/* End of File include/javascript/yui/build/yuiloader/yuiloader-min.js */

/*
     * More info at: http://phpjs.org
     *
     * This is version: 3.25
     * php.js is copyright 2011 Kevin van Zonneveld.
     *
     * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
     * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
     * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
     * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
     * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
     * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
     * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
     * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
     * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
     * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
     * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
     * (http://webdevhobo.blogspot.com/), d3x, marrtins,
     * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
     * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
     * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
     * Consulting Inc
     * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
     * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
     * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
     * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
     * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
     * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
     * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
     * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
     * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
     * Pellentesque Malesuada, felix, Michael White, Mailfaker
     * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
     * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
     * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
     * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
     * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
     * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
     * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
     * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
     * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
     * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
     * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
     * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
     * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
     * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
     * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
     * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
     * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
     * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
     * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
     * (http://yass.meetcweb.com), Peter-Paul Koch
     * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
     * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
     * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
     * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
     * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
     * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
     * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
     * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
     * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
     * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
     * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
     * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
     * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
     * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
     * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
     * (http://www.premasolutions.com/), Philippe Jausions
     * (http://pear.php.net/user/jausions), Aidan Lister
     * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
     * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
     * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
     * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
     * (http://www.pedrotainha.com), James, Arnout Kazemier
     * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
     * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
     * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
     * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
     * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
     * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
     * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
     * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
     * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
     * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
     * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
     * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
     * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
     * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
     * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
     * (http://benblume.co.uk/), DtTvB
     * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
     * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
     * (http://www.residence-mixte.com/), Kheang Hok Chin
     * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
     * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
     *
     * Dual licensed under the MIT (MIT-LICENSE.txt)
     * and GPL (GPL-LICENSE.txt) licenses.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a
     * copy of this software and associated documentation files (the
     * "Software"), to deal in the Software without restriction, including
     * without limitation the rights to use, copy, modify, merge, publish,
     * distribute, sublicense, and/or sell copies of the Software, and to
     * permit persons to whom the Software is furnished to do so, subject to
     * the following conditions:
     *
     * The above copyright notice and this permission notice shall be included
     * in all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
     * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
     * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
     * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
     * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
     * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
     * OTHER DEALINGS IN THE SOFTWARE.
     *//* 
 * More info at: http://phpjs.org
 * 
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 * 
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 * 
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

/* End of File include/javascript/phpjs/license.js */

/*
     * More info at: http://phpjs.org
     *
     * This is version: 3.25
     * php.js is copyright 2011 Kevin van Zonneveld.
     *
     * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
     * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
     * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
     * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
     * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
     * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
     * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
     * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
     * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
     * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
     * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
     * (http://webdevhobo.blogspot.com/), d3x, marrtins,
     * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
     * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
     * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
     * Consulting Inc
     * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
     * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
     * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
     * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
     * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
     * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
     * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
     * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
     * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
     * Pellentesque Malesuada, felix, Michael White, Mailfaker
     * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
     * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
     * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
     * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
     * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
     * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
     * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
     * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
     * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
     * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
     * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
     * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
     * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
     * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
     * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
     * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
     * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
     * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
     * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
     * (http://yass.meetcweb.com), Peter-Paul Koch
     * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
     * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
     * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
     * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
     * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
     * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
     * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
     * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
     * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
     * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
     * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
     * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
     * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
     * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
     * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
     * (http://www.premasolutions.com/), Philippe Jausions
     * (http://pear.php.net/user/jausions), Aidan Lister
     * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
     * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
     * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
     * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
     * (http://www.pedrotainha.com), James, Arnout Kazemier
     * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
     * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
     * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
     * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
     * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
     * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
     * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
     * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
     * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
     * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
     * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
     * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
     * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
     * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
     * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
     * (http://benblume.co.uk/), DtTvB
     * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
     * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
     * (http://www.residence-mixte.com/), Kheang Hok Chin
     * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
     * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
     *
     * Dual licensed under the MIT (MIT-LICENSE.txt)
     * and GPL (GPL-LICENSE.txt) licenses.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a
     * copy of this software and associated documentation files (the
     * "Software"), to deal in the Software without restriction, including
     * without limitation the rights to use, copy, modify, merge, publish,
     * distribute, sublicense, and/or sell copies of the Software, and to
     * permit persons to whom the Software is furnished to do so, subject to
     * the following conditions:
     *
     * The above copyright notice and this permission notice shall be included
     * in all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
     * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
     * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
     * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
     * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
     * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
     * OTHER DEALINGS IN THE SOFTWARE.
     *//*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

function get_html_translation_table (table, quote_style) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: noname
    // +   bugfixed by: Alex
    // +   bugfixed by: Marco
    // +   bugfixed by: madipta
    // +   improved by: KELAN
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Frank Forte
    // +   bugfixed by: T.Wild
    // +      input by: Ratheous
    // %          note: It has been decided that we're not going to add global
    // %          note: dependencies to php.js, meaning the constants are not
    // %          note: real constants, but strings instead. Integers are also supported if someone
    // %          note: chooses to create the constants themselves.
    // *     example 1: get_html_translation_table('HTML_SPECIALCHARS');
    // *     returns 1: {'"': '&quot;', '&': '&amp;', '<': '&lt;', '>': '&gt;'}
    var entities = {},
        hash_map = {},
        decimal = 0,
        symbol = '';
    var constMappingTable = {},
        constMappingQuoteStyle = {};
    var useTable = {},
        useQuoteStyle = {};

    // Translate arguments
    constMappingTable[0] = 'HTML_SPECIALCHARS';
    constMappingTable[1] = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';

    useTable = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT';

    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error("Table: " + useTable + ' not supported');
        // return false;
    }

    entities['38'] = '&amp;';
    if (useTable === 'HTML_ENTITIES') {
        entities['160'] = '&nbsp;';
        entities['161'] = '&iexcl;';
        entities['162'] = '&cent;';
        entities['163'] = '&pound;';
        entities['164'] = '&curren;';
        entities['165'] = '&yen;';
        entities['166'] = '&brvbar;';
        entities['167'] = '&sect;';
        entities['168'] = '&uml;';
        entities['169'] = '&copy;';
        entities['170'] = '&ordf;';
        entities['171'] = '&laquo;';
        entities['172'] = '&not;';
        entities['173'] = '&shy;';
        entities['174'] = '&reg;';
        entities['175'] = '&macr;';
        entities['176'] = '&deg;';
        entities['177'] = '&plusmn;';
        entities['178'] = '&sup2;';
        entities['179'] = '&sup3;';
        entities['180'] = '&acute;';
        entities['181'] = '&micro;';
        entities['182'] = '&para;';
        entities['183'] = '&middot;';
        entities['184'] = '&cedil;';
        entities['185'] = '&sup1;';
        entities['186'] = '&ordm;';
        entities['187'] = '&raquo;';
        entities['188'] = '&frac14;';
        entities['189'] = '&frac12;';
        entities['190'] = '&frac34;';
        entities['191'] = '&iquest;';
        entities['192'] = '&Agrave;';
        entities['193'] = '&Aacute;';
        entities['194'] = '&Acirc;';
        entities['195'] = '&Atilde;';
        entities['196'] = '&Auml;';
        entities['197'] = '&Aring;';
        entities['198'] = '&AElig;';
        entities['199'] = '&Ccedil;';
        entities['200'] = '&Egrave;';
        entities['201'] = '&Eacute;';
        entities['202'] = '&Ecirc;';
        entities['203'] = '&Euml;';
        entities['204'] = '&Igrave;';
        entities['205'] = '&Iacute;';
        entities['206'] = '&Icirc;';
        entities['207'] = '&Iuml;';
        entities['208'] = '&ETH;';
        entities['209'] = '&Ntilde;';
        entities['210'] = '&Ograve;';
        entities['211'] = '&Oacute;';
        entities['212'] = '&Ocirc;';
        entities['213'] = '&Otilde;';
        entities['214'] = '&Ouml;';
        entities['215'] = '&times;';
        entities['216'] = '&Oslash;';
        entities['217'] = '&Ugrave;';
        entities['218'] = '&Uacute;';
        entities['219'] = '&Ucirc;';
        entities['220'] = '&Uuml;';
        entities['221'] = '&Yacute;';
        entities['222'] = '&THORN;';
        entities['223'] = '&szlig;';
        entities['224'] = '&agrave;';
        entities['225'] = '&aacute;';
        entities['226'] = '&acirc;';
        entities['227'] = '&atilde;';
        entities['228'] = '&auml;';
        entities['229'] = '&aring;';
        entities['230'] = '&aelig;';
        entities['231'] = '&ccedil;';
        entities['232'] = '&egrave;';
        entities['233'] = '&eacute;';
        entities['234'] = '&ecirc;';
        entities['235'] = '&euml;';
        entities['236'] = '&igrave;';
        entities['237'] = '&iacute;';
        entities['238'] = '&icirc;';
        entities['239'] = '&iuml;';
        entities['240'] = '&eth;';
        entities['241'] = '&ntilde;';
        entities['242'] = '&ograve;';
        entities['243'] = '&oacute;';
        entities['244'] = '&ocirc;';
        entities['245'] = '&otilde;';
        entities['246'] = '&ouml;';
        entities['247'] = '&divide;';
        entities['248'] = '&oslash;';
        entities['249'] = '&ugrave;';
        entities['250'] = '&uacute;';
        entities['251'] = '&ucirc;';
        entities['252'] = '&uuml;';
        entities['253'] = '&yacute;';
        entities['254'] = '&thorn;';
        entities['255'] = '&yuml;';
    }

    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {
        entities['39'] = '&#39;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';


    // ascii decimals to real symbols
    for (decimal in entities) {
        symbol = String.fromCharCode(decimal);
        hash_map[symbol] = entities[decimal];
    }

    return hash_map;
}

/* End of File include/javascript/phpjs/get_html_translation_table.js */

/*
     * More info at: http://phpjs.org
     *
     * This is version: 3.25
     * php.js is copyright 2011 Kevin van Zonneveld.
     *
     * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
     * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
     * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
     * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
     * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
     * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
     * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
     * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
     * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
     * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
     * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
     * (http://webdevhobo.blogspot.com/), d3x, marrtins,
     * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
     * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
     * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
     * Consulting Inc
     * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
     * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
     * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
     * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
     * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
     * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
     * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
     * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
     * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
     * Pellentesque Malesuada, felix, Michael White, Mailfaker
     * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
     * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
     * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
     * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
     * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
     * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
     * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
     * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
     * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
     * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
     * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
     * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
     * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
     * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
     * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
     * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
     * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
     * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
     * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
     * (http://yass.meetcweb.com), Peter-Paul Koch
     * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
     * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
     * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
     * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
     * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
     * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
     * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
     * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
     * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
     * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
     * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
     * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
     * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
     * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
     * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
     * (http://www.premasolutions.com/), Philippe Jausions
     * (http://pear.php.net/user/jausions), Aidan Lister
     * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
     * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
     * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
     * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
     * (http://www.pedrotainha.com), James, Arnout Kazemier
     * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
     * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
     * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
     * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
     * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
     * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
     * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
     * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
     * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
     * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
     * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
     * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
     * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
     * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
     * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
     * (http://benblume.co.uk/), DtTvB
     * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
     * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
     * (http://www.residence-mixte.com/), Kheang Hok Chin
     * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
     * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
     *
     * Dual licensed under the MIT (MIT-LICENSE.txt)
     * and GPL (GPL-LICENSE.txt) licenses.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a
     * copy of this software and associated documentation files (the
     * "Software"), to deal in the Software without restriction, including
     * without limitation the rights to use, copy, modify, merge, publish,
     * distribute, sublicense, and/or sell copies of the Software, and to
     * permit persons to whom the Software is furnished to do so, subject to
     * the following conditions:
     *
     * The above copyright notice and this permission notice shall be included
     * in all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
     * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
     * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
     * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
     * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
     * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
     * OTHER DEALINGS IN THE SOFTWARE.
     *//*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

function html_entity_decode (string, quote_style) {
    // http://kevin.vanzonneveld.net
    // +   original by: john (http://www.jd-tech.net)
    // +      input by: ger
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: marc andreu
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Ratheous
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Nick Kolosov (http://sammy.ru)
    // +   bugfixed by: Fox
    // -    depends on: get_html_translation_table
    // *     example 1: html_entity_decode('Kevin &amp; van Zonneveld');
    // *     returns 1: 'Kevin & van Zonneveld'
    // *     example 2: html_entity_decode('&amp;lt;');
    // *     returns 2: '&lt;'
    var hash_map = {},
        symbol = '',
        tmp_str = '',
        entity = '';
    tmp_str = string.toString();

    if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }

    // fix &amp; problem
    // http://phpjs.org/functions/get_html_translation_table:416#comment_97660
    delete(hash_map['&']);
    hash_map['&'] = '&amp;';

    for (symbol in hash_map) {
        entity = hash_map[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }
    tmp_str = tmp_str.split('&#039;').join("'");

    return tmp_str;
}

/* End of File include/javascript/phpjs/html_entity_decode.js */

/*
     * More info at: http://phpjs.org
     *
     * This is version: 3.25
     * php.js is copyright 2011 Kevin van Zonneveld.
     *
     * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
     * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
     * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
     * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
     * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
     * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
     * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
     * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
     * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
     * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
     * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
     * (http://webdevhobo.blogspot.com/), d3x, marrtins,
     * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
     * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
     * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
     * Consulting Inc
     * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
     * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
     * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
     * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
     * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
     * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
     * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
     * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
     * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
     * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
     * Pellentesque Malesuada, felix, Michael White, Mailfaker
     * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
     * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
     * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
     * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
     * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
     * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
     * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
     * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
     * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
     * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
     * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
     * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
     * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
     * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
     * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
     * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
     * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
     * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
     * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
     * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
     * (http://yass.meetcweb.com), Peter-Paul Koch
     * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
     * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
     * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
     * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
     * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
     * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
     * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
     * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
     * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
     * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
     * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
     * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
     * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
     * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
     * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
     * (http://www.premasolutions.com/), Philippe Jausions
     * (http://pear.php.net/user/jausions), Aidan Lister
     * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
     * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
     * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
     * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
     * (http://www.pedrotainha.com), James, Arnout Kazemier
     * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
     * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
     * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
     * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
     * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
     * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
     * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
     * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
     * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
     * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
     * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
     * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
     * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
     * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
     * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
     * (http://benblume.co.uk/), DtTvB
     * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
     * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
     * (http://www.residence-mixte.com/), Kheang Hok Chin
     * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
     * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
     *
     * Dual licensed under the MIT (MIT-LICENSE.txt)
     * and GPL (GPL-LICENSE.txt) licenses.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a
     * copy of this software and associated documentation files (the
     * "Software"), to deal in the Software without restriction, including
     * without limitation the rights to use, copy, modify, merge, publish,
     * distribute, sublicense, and/or sell copies of the Software, and to
     * permit persons to whom the Software is furnished to do so, subject to
     * the following conditions:
     *
     * The above copyright notice and this permission notice shall be included
     * in all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
     * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
     * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
     * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
     * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
     * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
     * OTHER DEALINGS IN THE SOFTWARE.
     *//*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

function htmlentities (string, quote_style, charset, double_encode) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: nobbler
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Ratheous
    // +   improved by: Rafał Kukawski (http://blog.kukawski.pl)
    // +   improved by: Dj (http://phpjs.org/functions/htmlentities:425#comment_134018)
    // -    depends on: get_html_translation_table
    // *     example 1: htmlentities('Kevin & van Zonneveld');
    // *     returns 1: 'Kevin &amp; van Zonneveld'
    // *     example 2: htmlentities("foo'bar","ENT_QUOTES");
    // *     returns 2: 'foo&#039;bar'
    var hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style),
        symbol = '';
    string = string == null ? '' : string + '';

    if (!hash_map) {
        return false;
    }
    
    if (quote_style && quote_style === 'ENT_QUOTES') {
        hash_map["'"] = '&#039;';
    }
    
    if (!!double_encode || double_encode == null) {
        for (symbol in hash_map) {
            if (hash_map.hasOwnProperty(symbol)) {
                string = string.split(symbol).join(hash_map[symbol]);
            }
        }
    } else {
        string = string.replace(/([\s\S]*?)(&(?:#\d+|#x[\da-f]+|[a-zA-Z][\da-z]*);|$)/g, function (ignore, text, entity) {
            for (symbol in hash_map) {
                if (hash_map.hasOwnProperty(symbol)) {
                    text = text.split(symbol).join(hash_map[symbol]);
                }
            }
            
            return text + entity;
        });
    }

    return string;
}

/* End of File include/javascript/phpjs/htmlentities.js */

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * The current namespaces.
 */
if ( typeof(SUGAR) == 'undefined' ) SUGAR = {};
if ( typeof(SUGAR.util) == 'undefined' ) SUGAR.util = {};
if ( typeof(SUGAR.expressions) == 'undefined' ) SUGAR.expressions= {};

(function(){

SUGAR.util.extend = SUGAR.util.extend || (SUGAR.App ? SUGAR.App.utils.extendFrom : null);

/**
 * Constructs an Expression object given the parameters.
 */
var SEE = SUGAR.expressions.Expression = function(context) {
    this.context = context;
};


/**
 * Designates an infinite number of parameters.
 */
SEE.INFINITY = -1;

/**
 * The various types supported by Expression.
 */
SEE.STRING_TYPE   	= "string";
SEE.NUMERIC_TYPE  	= "number";
SEE.DATE_TYPE 	 	= "date";
SEE.TIME_TYPE 	 	= "time";
SEE.BOOLEAN_TYPE 	= "boolean";
SEE.ENUM_TYPE 	 	= "enum";
SEE.RELATE_TYPE	= "relate";
SEE.GENERIC_TYPE  	= "generic";

/**
 * The two boolean values.
 */
SEE.TRUE  = "true";
SEE.FALSE = "false";

/**
 * Checks whether a value is truthy.
 *
 * @param {Mixed} v The value to test.
 * @return {Boolean} `true` if truthy, `false` otherwise.
 */
SEE.isTruthy = function(v) {
    return _.isString(v) ? (v == "1" || v == SEE.TRUE) : !!v;
};

SUGAR.expressions.NumericConstants = {
	pi: 3.14159265,
	e: 2.718281828459045
}


/**
 * Initializes the Expression object.
 */
SEE.prototype.init = function(params) {
	// check if the parameter is an array with only one value
	if ( params instanceof Array && params.length == 1 ) {
		this.params = params[0];
	}

	// if params is an array or just a constant
	else {
		this.params = params;
	}

	// validate the parameters
	this.validateParameters();
};

/**
 * Returns the parameter list for this Expression.
 */
SEE.prototype.getParameters = function() {
	return this.params;
};

/**
 * Validates the parameters and throws an Exception if invalid.
 */
SEE.prototype.validateParameters = function() {
	var params = this.getParameters();
	var count  = this.getParamCount();
	var types  = this.getParameterTypes();

	/* parameter and type validation */

	// make sure count is a number
	if ( typeof(count) != 'number' ) {
		throw (this.getClass() + ": Number of paramters required must be a number");
	}

	// make sure types is a array or a string
	if ( typeof(types) != 'string' && ! (types instanceof Array) ) {
		throw (this.getClass() + ": Parameter types must be valid and match the parameter count");
	}

	// make sure sizeof types is equal to parameter count
	if ( types instanceof Array && count != SEE.INFINITY && count != types.length ) {
		throw (this.getClass() + ": Parameter types must be valid and match the parameter count");
	}

	// make sure types is valid
	if ( typeof(types) == 'string' ) {
		if ( SEE.TYPE_MAP[types] == null ) {
			throw (this.getClass() + ": Invalid type requirement '" + types + "'");
		}
	} else {
		for ( var i = 0; i < types.length; i++ ) {
			if ( typeof( SEE.TYPE_MAP[types[i]]) == 'undefined' ) {
				throw (this.getClass() + ": Invalid type requirement '" + types[i] + "'");
			}
		}
	}

	/* parameter and count validation */

	// if we want 0 params and we got 0 params, forget it
	if ( count == 0 && typeof(params) == 'undefined' )	{	return; }

	// if we want a single param, validate that param
	if ( count == 1 && this.isProperType(params, types) ) {	return; }

	// we require multiple but params only has 1
	if ( count > 1 && ! (params instanceof Array) ) {
		throw (this.getClass() + ": Requires exactly " + count + " parameter(s)");
	}

	// we require only 1 and params has multiple
	if ( count == 1 && params instanceof Array ) {
		throw (this.getClass() + ": Requires exactly 1 parameter");
	}

	// check parameter count
	if ( count != SEE.INFINITY && params instanceof Array && params.length != count ) {
		throw (this.getClass() + ": Requires exactly " + count + " parameter(s)");
	}

	// if a generic type is specified
	if ( typeof(types) == 'string' ) {
		// only a single parameter
		if ( ! (params instanceof Array) ) {
			if ( this.isProperType( params, types ) ) {
				return;
			}
			throw (this.getClass() + ": Parameter must be of type '" + types + "'");
		}

		// multiple parameters
		for ( var i = 0 ; i < params.length ; i ++ ) {
			if ( ! this.isProperType( params[i], types ) ) {
				throw (this.getClass() + ": All parameters must be of type '" + types + "'");
			}
		}
	}

	// if strict type constraints are specified
	else {
		// only a single parameter
		if ( ! (params instanceof Array) ) {
			if ( this.isProperType( params, types[0] ) ) {
				return;
			}
			throw (this.getClass() + ": Parameter must be of type '" + types[0] + "'");
		}

		// improper type
		for ( var i = 0 ; i < types.length ; i++ ) {
			if ( ! this.isProperType( params[i], types[i] ) ) {
				throw (this.getClass() + ": The parameter at index " + i + " must be of type " + types[i] );
			}
		}
	}
};

/**
 * Returns the exact number of parameters needed.
 */
SEE.prototype.getParamCount = function() {
	return SEE.INFINITY;
};

/**
 * Enforces the parameter types.
 */
SEE.prototype.isProperType = function(variable, type) {
	var see = SEE;
	if ( type instanceof Array ) {
		return false;
	}

	// retrieve the class
	var c = see.TYPE_MAP[type];

	// check if type is empty
	if ( typeof(c) == 'undefined' || c == null || c == '' ) {
		return false;
	}

	// check if it's an instance of type or a generic that could map to any (unknown type)
	if  (variable instanceof c || variable instanceof see.TYPE_MAP.generic || type == see.GENERIC_TYPE)
        return true;

	// now check for generics
    if (variable instanceof see) {
        variable = variable.evaluate();
    }

	switch(type) {
		case see.STRING_TYPE:
			return (typeof(variable) == 'string' || typeof(variable) == 'number'
                || variable instanceof see.TYPE_MAP[see.NUMERIC_TYPE]);
			break;
		case see.NUMERIC_TYPE:
			return (typeof(variable) == 'number' || SUGAR.expressions.isNumeric(variable));
			break;
        case see.BOOLEAN_TYPE:
            return variable == see.TRUE || variable == see.FALSE ||
                variable === 1 || variable === 0 ||
                variable === '1' || variable === '0' ||
                variable === '';
            break;
        case see.DATE_TYPE:
        case see.TIME_TYPE:
            // Empty string and NULL are valid values of date fields.
            // The expressions using them should be responsible for proper handling of empty values.
            if (variable === null || variable === ''
                || (typeof(variable) == 'string' && SUGAR.util.DateUtils.guessFormat(variable)))
                return true;
            break;
		case see.RELATE_TYPE:
			return true;
			break;
	}

	// If its not an instane and we can't map the value to a type, return false.
	return false;
};

/** ABSTRACT METHODS **/

/**
 * Evaluates this expression and returns the resulting value.
 */
SEE.prototype.evaluate = function() {
	// does nothing .. needs to be overridden
};

/**
 * Gets the name of the expression passed in.
 * @param {Object} exp
 */
SEE.prototype.getClass = function(exp) {
	for (var i in SUGAR.FunctionMap){
		if (typeof SUGAR.FunctionMap[i] == "function" && SUGAR.FunctionMap[i].prototype 
			&& this instanceof SUGAR.FunctionMap[i])
			return i;
	}
	return false;
};

/**
 * Returns the type each parameter should be.
 */
SEE.prototype.getParameterTypes = function() {
	// does nothing .. needs to be overridden
};



/** GENERIC TYPE EXPRESSIONS **/
SUGAR.expressions.GenericExpression = function(params) {

};
SUGAR.util.extend(SUGAR.expressions.GenericExpression, SEE, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SEE.GENERIC_TYPE;
	}
});


/**
 * Construct a new NumericExpression.
 */
SUGAR.expressions.NumericExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.NumericExpression, SEE, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SEE.NUMERIC_TYPE;
	}
});


/**
 * Construct a new StringExpression.
 */
SUGAR.expressions.StringExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.StringExpression, SEE, {
	/**
	 * All parameters have to be a string by default.
	 */
	getParameterTypes: function() {
		return SEE.STRING_TYPE;
	}
});


/**
 * Construct a new BooleanExpression.
 */
SUGAR.expressions.BooleanExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.BooleanExpression, SEE, {
	/**
	 * All parameters have to be a sugar-boolean by default.
	 */
	getParameterTypes: function() {
		return SEE.BOOLEAN_TYPE;
	}
});


/**
 * Construct a new EnumExpression.
 */
SUGAR.expressions.EnumExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.EnumExpression, SEE, {
	/**
	 * All parameters have to be an enumeration by default.
	 */
	getParameterTypes: function() {
		return SEE.ENUM_TYPE;
	}
});


/**
 * Construct a new DateExpression.
 */
SUGAR.expressions.DateExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.DateExpression, SEE, {
	/**
	 * All parameters have to be date by default.
	 */
	getParameterTypes: function() {
		return SEE.DATE_TYPE;
	}
});


/**
 * Construct a new TimeExpression.
 */
SUGAR.expressions.TimeExpression = function(params) {
	//this.init(params);
};
SUGAR.util.extend(SUGAR.expressions.TimeExpression, SEE, {
	/**
	 * All parameters have to be time by default.
	 */
	getParameterTypes: function() {
		return SEE.TIME_TYPE;
	}
});

SUGAR.expressions.RelateExpression = function(params) {

};
SUGAR.util.extend(SUGAR.expressions.RelateExpression, SEE, {
	/**
	 * All parameters have to be a number by default.
	 */
	getParameterTypes: function() {
		return SEE.GENERIC_TYPE;
	}
});




/**
 * The type to object map for dynamic expression
 * creation and type validation.
 */
SEE.TYPE_MAP	= {
		"number" 	: SUGAR.expressions.NumericExpression,
		"string" 	: SUGAR.expressions.StringExpression,
		"date" 		: SUGAR.expressions.DateExpression,
		"time" 		: SUGAR.expressions.TimeExpression,
		"boolean" 	: SUGAR.expressions.BooleanExpression,
		"enum" 		: SUGAR.expressions.EnumExpression,
		"relate" 	: SUGAR.expressions.RelateExpression,
		"generic" 	: SUGAR.expressions.GenericExpression
};



/**
 * Construct a new ConstantExpression.
 */
SUGAR.expressions.ConstantExpression = function(params) {
	this.init(params);
}

SUGAR.util.extend(SUGAR.expressions.ConstantExpression, SUGAR.expressions.NumericExpression, {
	evaluate: function() {
		return this.getParameters();
	},
	getParamCount: function() {
		return 1;
	}
});

/**
 * Construct a new StringLiteralExpression.
 */
SUGAR.expressions.StringLiteralExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.StringLiteralExpression, SUGAR.expressions.StringExpression, {
	evaluate: function() {
		return this.getParameters();
	},
	getParamCount: function() {
		return 1;
	}
});

/**
 * Construct a new FalseExpression.
 */
SUGAR.expressions.FalseExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.FalseExpression, SUGAR.expressions.BooleanExpression, {
	evaluate: function() {
		return SEE.FALSE;
	},
	getParamCount: function() {
		return 0;
	}
});

/**
 * Construct a new TrueExpression.
 */
SUGAR.expressions.TrueExpression = function(params) {
	this.init(params);
}
SUGAR.util.extend(SUGAR.expressions.TrueExpression, SUGAR.expressions.BooleanExpression, {
	evaluate: function() {
		return SEE.TRUE;
	},
	getParamCount: function() {
		return 0;
	}
});

/**
 * The ExpressionParser object.
 */
var SEP = SUGAR.expressions.ExpressionParser = function() {
	// nothing
};

SEP.prototype.getFieldsFromExpression = function(expression)
{
	var re = /[^$]*?\$(\w+)[^$]*?/g,
		matches = [],
		result;
	while (result = re.exec(expression))
	{
		matches.push(result[result.length-1]);
	}
	return matches;
}


SEP.prototype._generateRange = function(prefix, start, end)
{
    var str = "";
    var i = parseInt(start);
    if ( typeof(end) == 'undefined' )
        while ( this.getElement(prefix + '' + i) != null )
            str += '$' + prefix + '' + (i++) + ',';
    else
        for ( ; i <= end ; i ++ ) {
            var t = prefix + '' + i;
            if ( this.getElement(t) != null )
                str += '$' + t + ',';
        }
    return str.substring(0, str.length-1);
}

SEP.prototype._valueReplace = function(val) {
    if ( !(/^\$.*$/).test(val) )
    {
        return val;
    }

    return this.getValue(val.substring(1));
}

SEP.prototype._performRangeReplace = function(expression)
{
    var isInQuotes = false;
    var prev;
    var inRange;

    // go character by character
    for ( var i = 0 ;  ; i ++ ) {
        // due to fluctuating expression length
        if ( i == expression.length ) break;

        var ch = expression.charAt(i);

        if ( ch == '"' && prev != '\\' )	isInQuotes = !isInQuotes;

        if ( !isInQuotes && ch == '%' ) {
            inRange = true;

            // perform the replace
            var loc_start = expression.indexOf( '[' , i+1 );
            var loc_comma = expression.indexOf(',', loc_start );
            var loc_end   = expression.indexOf(']', loc_start );

            // invalid expression syntax?
            if ( loc_start < 0 || loc_end < 0 )	throw ("Invalid range syntax");

            // construct the pieces
            var prefix = expression.substring( i+1 , loc_start );
            var start, end;

            // optional param is there
            if ( loc_comma > -1 && loc_comma < loc_end ) {
                start = expression.substring( loc_start+1, loc_comma );
                end = expression.substring( loc_comma + 1, loc_end );
            } else {
                start = expression.substring( loc_start+1, loc_end );
            }

            // optional param is there
            if ( loc_comma > -1 && loc_comma < loc_end )	end = expression.substring( loc_comma + 1, loc_end );

            // construct the range
            var result = this._generateRange(prefix, this._valueReplace(start), this._valueReplace(end));
            //var result = this.generateRange(prefix, start, end);

            // now perform the replace
            if ( typeof(end) == 'undefined' )
                expression = expression.replace('%'+prefix+'['+start+']', result);
            else
                expression = expression.replace('%'+prefix+'['+start+','+end+']', result);

            // skip on
            i = i + result.length - 1;
        }

        prev = ch;
    }

    return expression;
}
SEP.prototype.validate = function(expr)
{
	if ( typeof(expr) != 'string' )	throw "ExpressionParser requires a string expression.";
	// check if its a constant and return a constant expression
	var fixed = this.toConstant(expr);

	if ( fixed != null && typeof(fixed) != 'undefined' )
		return true;

	// VALIDATE: expression format
	if ((/^[\w\-]+\(.*\)$/).exec(expr) == null) {
		throw ("Syntax Error (Expression Format Incorrect '" + expr + "' )");
	}

	// if no open-paren '(' found
	if ( expr.indexOf('(') < 0 )
		throw ("Syntax Error (No opening paranthesis found)");

	return true;
}

SEP.prototype.tokenize = function(expr)
{
	var fixed = this.toConstant(expr);
	if ( fixed != null && typeof(fixed) != 'undefined' )
	{
		return {
			type: "constant",
			returnType : this.getType(fixed),
            value : fixed.evaluate()
		}
	}

	if(/^[$]\w+$/.test(expr))
	{
		return {
			type:"variable",
			name:$.trim(expr).substr(1)
		}
	}
	//Related Field
	if(/^[$]\w+\.\w+$/.test(expr))
	{
		expr = $.trim(expr);
		return {
			type:"variable",
			name: expr.substr(1, expr.indexOf('.') - 1),
			relate: expr.substr(expr.indexOf('.') + 1)
		}
	}

	// EXTRACT: Function
	var open_paren_loc = expr.indexOf('(');
	if (open_paren_loc < 1)
		throw (expr + ": Syntax Error, no open parentheses found");
	if (expr.charAt(expr.length-1) != ')')
		throw (expr + ": Syntax Error, no close parentheses found");

	// get the function
	var func = expr.substring(0, open_paren_loc);

	// EXTRACT: Parameters
	var params = expr.substring(open_paren_loc + 1, expr.length-1);

	// now parse the individual parameters recursively
	var level  = 0;
	var length = params.length;
	var argument = "";
	var args = new Array();

	// flags
	var currChar		= null;
	var lastCharRead	= null;
	var justReadString	= false;		// did i just read in a string
	var justReadComma   = false;
	var isInQuotes 		= false;		// am i currently reading in a string
	var isPrevCharBK 	= false;		// is my previous character a backslash

	for ( var i = 0 ; i <= length ; i++ ) {
		// store the last character read
		lastCharRead = currChar;
		justReadComma = false;

		// the last parameter
		if ( i == length ) {
			argument = $.trim(argument);
			if (argument != "")
				args[args.length] = this.tokenize(argument);
			break;
		}

		// set isprevcharbk
		isPrevCharBK = ( lastCharRead == '\\' );

		// get the charAt index i
		currChar = params.charAt(i);

		// if i am in quotes, then keep reading
		if ( isInQuotes && currChar != '"' && !isPrevCharBK ) {
			argument += currChar;
			continue;
		}

		// check for quotes
		if ( currChar == '"' && !isPrevCharBK && level == 0 )
		{
			// if i am ending a quote, then make sure nothing follows
			if ( isInQuotes ) {
				// only spaces may follow the end of a string
				var end_reg = params.indexOf(",", i);
				if ( end_reg < 0 )	end_reg = params.length-1;
				var start_reg = ( i < length - 1 ? i+1 : length - 1);

				var temp = params.substring(start_reg , end_reg );
				if ( (/^\s*$/).exec(temp) == null )
					throw (func + ": Syntax Error (Improperly Terminated String '" + temp + "')" + (start_reg) + " " + end_reg);
			}

			// negate if i am in quotes
			isInQuotes = !isInQuotes;
		}

		// check parantheses open/close
		if ( currChar == '(' ) {
			level++;
		} else if ( currChar == ')' ) {
			level--;
		}

		// argument splitting
		else if ( currChar == ',' && level == 0 ) {
			argument = $.trim(argument);
			if (argument == "")
				throw ("Syntax Error: Unexpected ','");
				args[args.length] = this.tokenize(argument);
			argument = "";
			justReadComma = true;
			continue;
		}

		// construct the next argument
		argument += currChar;
	}

	// now check to make sure all the quotes opened were closed
	if ( isInQuotes )	 throw ("Syntax Error (Unterminated String Literal)");

	// now check to make sure all the parantheses opened were closed
	if ( level != 0 )	 throw ("Syntax Error (Incorrectly Matched Parantheses)");

	//If we hit a comma, but no paramter follows, we shoudl throw an error. 
	if ( justReadComma ) throw ("Syntax Error (No parameter after comma near <b>" + func + "</b>)");

	// require and return the appropriate expression object
	return {
		type: "function",
		name: $.trim(func),
		args: args
	}
}


SEP.prototype.getType = function(variable) {
	for(var type in SEE.TYPE_MAP)
	{
		if (variable instanceof SEE.TYPE_MAP[type])
		{
			return type;
		}
	}

	return false;
};

/**
 * Evaluate a given string expression and return an Expression
 * object.
 */
SEP.prototype.evaluate = function(expr, context)
{
	// make sure it is only parsing strings
	if ( typeof(expr) != 'string' )	throw "ExpressionParser requires a string expression.";

	// trim spaces, left and right
	expr = expr.replace(/^\s+|\s+$|\n/g,"");

	// check if its a constant and return a constant expression
	var fixed = this.toConstant(expr);
	if ( fixed != null && typeof(fixed) != 'undefined' )
		return fixed;

	//Check if the expression is just a variable
	if (expr.match(/^\$\w+$/))
	{
		if (typeof (context) == "undefined")
			throw ("Syntax Error: variable " + expr + " without context");
		return context.getValue(expr.substring(1));
	}

	if (expr.match(/^\$\w+\.\w+$/))
	{
		return context.getRelatedValue(
				expr.substr(1, expr.indexOf('.') - 1),
				expr.substr(expr.indexOf('.') + 1)
		);
	}

	// VALIDATE: expression format
	if ((/^[\w\-]+\(.*\)$/).exec(expr) == null) {
		throw ("Syntax Error (Expression Format Incorrect '" + expr + "' )");
	}

	// EXTRACT: Function
	var open_paren_loc = expr.indexOf('(');

	// if no open-paren '(' found
	if ( open_paren_loc < 0 )
		throw ("Syntax Error (No opening paranthesis found)");

	// get the function
	var func = expr.substring(0, open_paren_loc);

	if ( SUGAR.FunctionMap[func] == null )
		throw (func + ": No such function defined");

	// EXTRACT: Parameters
	var params = expr.substring(open_paren_loc + 1, expr.length-1);

	// now parse the individual parameters recursively
	var level  = 0;
	var length = params.length;
	var argument = "";
	var args = new Array();

	// flags
	var currChar		= null;
	var lastCharRead	= null;
	var justReadString	= false;		// did i just read in a string
	var isInQuotes 		= false;		// am i currently reading in a string
	var isPrevCharBK 	= false;		// is my previous character a backslash
	var isInVar 		= false;		// am i currently reading a variable name

	if (length > 0) { for ( var i = 0 ; i <= length ; i++ ) {
		// store the last character read
		lastCharRead = currChar;

		// the last parameter
		if ( i == length ) {
			args[args.length] = this.evaluate(argument, context);
			break;
		}

		// set isprevcharbk
		isPrevCharBK = ( lastCharRead == '\\' );

		// get the charAt index i
		currChar = params.charAt(i);

		// if i am in quotes, then keep reading
		if ( isInQuotes && currChar != '"' && !isPrevCharBK ) {
			argument += currChar;
			continue;
		}

		if (isInVar && (currChar == " " || currChar == "," ))
			isInVar = false;
		
		// check for quotes
		if ( currChar == '"' && !isPrevCharBK && level == 0 )
		{
			// if i am ending a quote, then make sure nothing follows
			if ( isInQuotes ) {
				// only spaces may follow the end of a string
				var end_reg = params.indexOf(",", i);
				if ( end_reg < 0 )	end_reg = params.length-1;
				var start_reg = ( i < length - 1 ? i+1 : length - 1);

				var temp = params.substring(start_reg , end_reg );
				if ( (/^\s*$/).exec(temp) == null )
					throw (func + ": Syntax Error (Improperly Terminated String '" + temp + "')" + (start_reg) + " " + end_reg);
			}

			// negate if i am in quotes
			isInQuotes = !isInQuotes;
		}

		if( currChar == '$' && !isPrevCharBK && !isInQuotes && level == 0)
		{
			if (isInVar)
				throw (func + ": Syntax Error (unexpeted '$' in  '" + argument + "')");
			else {
				isInVar = true;
			}
		}

		// check parantheses open/close
		if ( currChar == '(' ) {
			level++;
		} else if ( currChar == ')' ) {
			level--;
		}

		// argument splitting
		else if ( currChar == ',' && level == 0 ) {
			args[args.length] = this.evaluate(argument, context);
			argument = "";
			continue;
		}

		// construct the next argument
		argument += currChar;
	}}

	// now check to make sure all the quotes opened were closed
	if ( isInQuotes )	throw ("Syntax Error (Unterminated String Literal)");

	// now check to make sure all the parantheses opened were closed
	if ( level != 0 )	throw ("Syntax Error (Incorrectly Matched Parantheses)");

	// require and return the appropriate expression object
	return new SUGAR.FunctionMap[func](args, context);
}



/**
 * Takes in a string and returns a ConstantExpression if the
 * string can be converted to a constant.
 */
SEP.prototype.toConstant = function(expr) {

	// a raw numeric constant
	if (isFinite(expr) && !isNaN(parseFloat(expr))) {
		return new SUGAR.expressions.ConstantExpression( parseFloat(expr) );
	}

	// a pre defined numeric constant
	var fixed = SUGAR.expressions.NumericConstants[expr];
	if ( fixed != null && typeof(fixed) != 'undefined' )
		return new SUGAR.expressions.ConstantExpression( parseFloat(fixed) );

	// a constant string literal
    if ((/^"[\s\S]*"$/).exec(expr) != null) {
		expr = expr.substring(1, expr.length-1);		// remove start/end quotes
		return new SUGAR.expressions.StringLiteralExpression( expr );
	}

    // empty string
    if (expr == '')
    {
        return new SUGAR.expressions.StringLiteralExpression( expr );
    }

	// a boolean
	if ( expr == "true" ) {
		return new SUGAR.expressions.TrueExpression();
	} else if ( expr == "false" ) {
		return new SUGAR.expressions.FalseExpression();
	}

	// a date
	if ( (/^(0[0-9]|1[0-2])\/([0-2][0-9]|3[0-1])\/[0-3][0-9]{3,3}$/).exec(expr) != null ) {
		var day   = parseFloat(expr.substring(0, 2));
		var month = parseFloat(expr.substring(3, 2));
		var year  = parseFloat(expr.substring(6, 4));
		return new SUGAR.DateExpression([day, month, year]);
	}

	// a time
	if ( (/^([0-1][0-9]|2[0-4]):[0-5][0-9]:[0-5][0-9]$/).exec(expr) != null ) {
		var hour   = parseFloat(expr.substring(0, 2));
		var minute = parseFloat(expr.substring(3, 2));
		var second = parseFloat(expr.substring(6, 2));
		return new SUGAR.TimeExpression([hour, minute, second]);
	}

	// neither
	return null;
};

SEP.prototype.getRelatedFieldsFromFormula = function(expr) {
    var fields = [],
        relateFunctions = ["related", "count", "rollupSum", "rollupMax", 'rollupMin', "rollupAve", "rollupCurrencySum"];
    var recurseTokens = function(t){
        //First check if its a simple related field
        if (t.type == "variable" && t.relate){
            fields.push({
                type:"related",
                link:t.name,
                relate:t.relate
            });
        } else if (t.type == "function" && relateFunctions.indexOf(t.name) != -1)
        {
            switch(t.name){
                case "related":
                    // For now, do not attempt to prefetch relate fields that use a formula to determine what related field to pull from
                    if (t.args[1].type == "constant")
                        fields.push({
                            type:"related",
                            link:t.args[0].name,
                            relate:t.args[1].value
                        });
                    break;
                case "count":
                    //count has no field parameter, only a link
                    fields.push({
                        type:"count",
                        link:t.args[0].name
                    });
                    break;
                default:
                    //Default will be a rollup, again, no nested formulas allowed
                    if (t.args[1].type == "constant")
                    {
                        fields.push({
                            type:t.name,
                            link:t.args[0].name,
                            relate:t.args[1].value
                        });
                    }
            }
        } else if (t.type == "function") {
            for(var i = 0; i < t.args.length; i++){
                recurseTokens(t.args[i]);
            }
        }
    }
    try {
        var t = this.tokenize(expr);
        recurseTokens(t);
    }
    catch(e){}

    return fields;
}

/**
 * An expression context is used to retrieve variables when evaluating expressions.
 * the default class only returns the empty string.
 */
var SEC = SUGAR.expressions.ExpressionContext = function()
{
	//No opp, this is just an API
}

SEC.prototype.getValue = function(varname)
{
	return "";
}

SEC.prototype.setValue = function(varname, value)
{
	return "";
}

SEC.prototype.addListener = function(varname, callback, scope)
{
	return "";
}


SEC.prototype.getRelatedValue = function(linkField, relField)
{
	return new SUGAR.RelatedFieldExpression([
		new SUGAR.expressions.StringLiteralExpression( linkField ),
		new SUGAR.expressions.StringLiteralExpression( relField )
	]);
}

SUGAR.expressions.isNumeric = function(str) {
    if (typeof(str) != 'number' && typeof(str) != 'string') {
        return false;
    }
    str = SUGAR.expressions.unFormatNumber(str);
    return (isFinite(str) && !isNaN(parseFloat(str)));

};

SUGAR.expressions.unFormatNumber = function(num) {
    if(typeof num == 'string')
    {
    var SE = SUGAR.expressions;
    var ts = "," , ds= ".";
    if (SE.userPrefs) {
        ts = SE.userPrefs.num_grp_sep;
        ds = SE.userPrefs.dec_sep;
    };
    num = SE.replaceAll(num, ts, "");
    num = SE.replaceAll(num, ds, ".");
    }
    return num;
};

SUGAR.expressions.replaceAll = function(haystack, needle, rpl) {
    if (needle == rpl || haystack == "" || needle == "") return haystack;
    var str = haystack;
    while ( str.indexOf(needle) > -1 ) {
        str = str.replace(needle, rpl);
    }
    return str;
};

/**
 * 
 */
 
SUGAR.util.DateUtils = {
	/**
 	 * Converts a date string to a new format.
 	 * If no new format is passed in, the date is returned as a Unix timestamp.
 	 * If no old format is passed in, the old format is guessed.
 	 * @param {String} date String representing a date.
 	 * @param {String} oldFormat Optional: Current format of the date string.
 	 */
	parse : function(date, oldFormat) {
        if (date instanceof Date)
            return date;
        if (oldFormat == "user")
		{
			if (SUGAR.expressions.userPrefs && SUGAR.expressions.userPrefs.datef) {
				oldFormat = SUGAR.expressions.userPrefs.datef + " " + SUGAR.expressions.userPrefs.timef;
			} else {
				oldFormat = SUGAR.util.DateUtils.guessFormat(date);
			}
		}
		if (oldFormat == null || oldFormat == "") {
			oldFormat = SUGAR.util.DateUtils.guessFormat(date);
		}
		if (oldFormat == false) {
			//Check if date is a timestamp
			if (/^\d+$/.test(date))
				return new Date(date);
			//Otherwise give up
			return false;
		}
		var jsDate = new Date("Jan 1, 1970 00:00:00");
		var part = "";
		var dateRemain = $.trim(date);
		oldFormat = $.trim(oldFormat) + " "; // Trailing space to read as last separator.
		for (var j = 0; j < oldFormat.length; j++) {
			var c = oldFormat.charAt(j);
            if (c == ':' || c == '/' || c == '-' || c == '.' || c == " " || c == 'a' || c == "A" || c == "T") {
				var i = dateRemain.indexOf(c);
				if (i == -1) i = dateRemain.length;
				var v = dateRemain.substring(0, i);
				dateRemain = dateRemain.substring(i+1);
				switch (part) {
					case 'm':
						if (!(v > 0 && v < 13)) return false;
						jsDate.setMonth(v - 1); break;
					case 'd':
						if(!(v > 0 && v < 32)) return false;
						jsDate.setDate(v); break;
					case 'Y':
						if(!(v > 0)) return false;
						jsDate.setYear(v); break;
					case 'h':
						//Read time, assume minutes are at end of date string (we do not accept seconds)
						var timeformat = oldFormat.substring(oldFormat.length - 4);
						if (timeformat.toLowerCase() == "i a " || timeformat.toLowerCase() == c + "ia ") {
							if (dateRemain.substring(dateRemain.length - 2).toLowerCase() == 'pm') {
								v = v * 1;
								if (v < 12) {
									v += 12;
								}
							}
						}
					case 'H':
						jsDate.setHours(v);
						break;
					case 'i':
						v = v.substring(0, 2);
						jsDate.setMinutes(v); break;
				}
				part = "";
			} else {
				part = c;
			}
		}
		return jsDate;
	},
	guessFormat: function(date) {
		if (typeof date != "string")
			return false;
		//Is there a time
		var time = "";
        var dateTimeSep;
        if (date.indexOf(" ") != -1) {
            dateTimeSep = " ";
        } else if (date.indexOf("T") != -1) {
            dateTimeSep = "T";
        }
        if (dateTimeSep) {
            time = date.substring(date.indexOf(dateTimeSep) + 1, date.length);
            date = date.substring(0, date.indexOf(dateTimeSep));
        }

		//First detect if the date contains "-" or "/"
		var dateSep = "/";
		if (date.indexOf("/") != -1){}
		else if (date.indexOf("-") != -1)
		{
			dateSep = "-";
		} 
		else if (date.indexOf(".") != -1)
		{
			dateSep = ".";
		}
		else 
		{
		 	return false;
		}
		var dateParts = date.split(dateSep);
		var dateFormat = "";
		var jsDate = new Date("Jan 1, 1970 00:00:00");
		if (dateParts[0].length == 4)
		{
			dateFormat = "Y" + dateSep + "m" + dateSep + "d";
		}
		else if (dateParts[2].length == 4)
		{
			dateFormat = "m" + dateSep + "d" + dateSep + "Y";
		}
		else 
		{
			return false;
		}

		//Detect the Time format
		if (time != "")
		{
			var timeFormat = "";
			var timeSep = ":";
			if (time.indexOf(".") == 2) {
				timeSep = ".";
			}
			if (time.indexOf(" ") != -1) {
				var timeParts = time.split(" ");
				if (timeParts[1] == "am" || timeParts[1] == "pm") {
                    return dateFormat + dateTimeSep + "h" + timeSep + "i a";
				} else if (timeParts[1] == "AM" || timeParts[1] == "PM") {
                    return dateFormat + dateTimeSep + "h" + timeSep + "i A";
				}	
			}
			else 
			{
				var timeEnd = time.substring(time.length - 2, time.length);
				if (timeEnd == "AM" || timeEnd == "PM") {
                    return dateFormat + dateTimeSep + "h" + timeSep + "iA";
				}
				if (timeEnd == "am" || timeEnd == "pm") {
                    return dateFormat + dateTimeSep + "h" + timeSep + "iA";
				}

                return dateFormat + dateTimeSep + "H" + timeSep + "i";
			}
		}

		return dateFormat;
	},

    formatDate : function(date, useTime, format)
    {
        if (!format && SUGAR.expressions.userPrefs.datef && SUGAR.expressions.userPrefs.timef) {
            if (useTime)
				format = SUGAR.expressions.userPrefs.datef + " " + SUGAR.expressions.userPrefs.timef;
			else
				format = SUGAR.expressions.userPrefs.datef;
        }
        var out = "";
        for (var i=0; i < format.length; i++) {
			var c = format.charAt(i);
			switch (c) {
                case 'm':
                    var m= date.getMonth() + 1; 
                    out += m < 10 ? "0" + m : m;
                    break;
                case 'd':
                    var d = date.getDate();
                    out += d < 10 ? "0" + d : d;
                    break;
                case 'Y':
                    out += date.getFullYear(); break;
				case 'H':
                case 'h':
					var h = date.getHours();
                    if(c == "h") h = h > 12 ? h - 12 : h;
                    out += h < 10 ? "0" + h : h; break;
                case 'i':
                    var m = date.getMinutes();
                    out += m < 10 ? "0" + m : m; break;
                case 'a':
                    if (date.getHours() < 12)
                        out += "am";
                    else
                        out += "pm";
                    break;
                case 'A':
                    if (date.getHours() < 12)
                        out += "AM";
                    else
                        out += "PM";
                    break;
                default :
                    out += c;
            }
		}
        return out;
    },
	roundTime: function(date)
	{
		var min = date.getMinutes();

		if (min < 1) { min = 0; }
		else if (min < 16) { min = 15; }
		else if (min < 31) { min = 30; }
		else if (min < 46) { min = 45; }
		else { min = 0; date.setHours(date.getHours() + 1)}

		date.setMinutes(min);

		return date;
	},
	getUserTime: function()
	{
		var date = new Date();
		if (SUGAR.expressions.userPrefs &&
            typeof(SUGAR.expressions.userPrefs.gmt_offset) != 'undefined')
		{
			//Sugars TZ offset is negative compared with JS's offset, so adding is really subtracting;
			var offset = SUGAR.expressions.userPrefs.gmt_offset;
			date.setMinutes(date.getMinutes() + (date.getTimezoneOffset() + offset));
		}
		return date;
	}
 };

})();

/* End of File sidecar/lib/sugarlogic/expressions.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */


(function() {

/**
 * This JavaScript file provides an entire framework for the new
 * SUGAR Calculated Fields/Dependent Dropdowns implementation.
 * This is integrated heavily with the SUGAR Expressions engine
 * which does the actual input validation and expression
 * calculations behind the scenes.
 *
 * @import sugar_expressions.php
 * @import formvalidation.js  (RequireDependency function)
 * @import yui-dom-event.js	    (although, we could do without this in the future)
 */

// namespace
if ( typeof(SUGAR.forms) == 'undefined' )	SUGAR.forms = {};
if ( typeof(SUGAR.forms.animation) == 'undefined') SUGAR.forms.animation = {};

var Dom = YAHOO.util.Dom;

/**
 * @STATIC
 * The main assignment handler which maintains a registry of the
 * current variables in use and the appropriate fields they map to.
 * It can assign values to variables and retrieve the values of
 * variables. Also, it animates the updated fields if necessary
 * to indicate a change in value to the user.
 */
var AH = SUGAR.forms.AssignmentHandler = function() {
	// pass ...
}

/**
 * @STATIC
 * This flag determines whether animations are turned on/off.
 */
AH.ANIMATE = true;

    /**
  * @STATIC
 * This array maps form elements to their respective element in DOM.
 */
AH.COLLECTIONS_MAP = {};

    /**
 * @STATIC
 *  * Event which is fired after loadComplete method is done.
 * Meaning it that all the onload dependencies were fired.
 */
AH.AFTER_LOAD_COMPLETE = new YAHOO.util.CustomEvent("AFTER_LOAD_COMPLETE");

/**
 * @STATIC
 * This array maps variables to their respective element id's.
 */
AH.VARIABLE_MAP = {};

/**
 * @STATIC
 * This array maps variables to a set of listeners
 */
AH.LISTENERS = {};

/**
 * @STATIC
 * This array contains a list of valid relationship links for this module
 */
AH.LINKS = {};

/**
 * @STATIC
 * This array contains the list of locked variables. (For Detection of Circular References)
 */
AH.LOCKS = {};

AH.QUEUEDDEPS = [];



/**
 * @STATIC
 * Register a variable with the handler.
 */
AH.register = function(variable, view) {
	if (!view) view = AH.lastView;

	if (typeof(AH.VARIABLE_MAP[view]) == "undefined")
		AH.VARIABLE_MAP[view] = {};

	if ( variable instanceof Array ) {
		for ( var i = 0; i < variable.length; i++ ) {
			AH.VARIABLE_MAP[view][variable[i]] = document.getElementById(variable[i]);
		}
	} else {
		AH.VARIABLE_MAP[view][variable] = document.getElementById(variable);
	}
}


/**
 * @STATIC
 * Register form fields with the handler.
 */
AH.registerFields = function(flds) {
	if ( typeof(flds) != 'object' ) return;
	var form = document.forms[flds.form];
	var names = flds.fields;
	if (typeof(AH.VARIABLE_MAP[flds.form]) == "undefined")
		AH.VARIABLE_MAP[flds.form] = {};
	if ( typeof(form) == 'undefined' ) return;
	for ( var i = 0; i < names.length; i++ ) {
		var el = form[names[i]];
		if ( el != null ){
            AH.VARIABLE_MAP[flds.form][el.id] = el;
            AH.updateListeners(el.id, flds.form, el);
        }
	}
}

/**
 * @STATIC
 * Register all the fields in a form
 */
AH.registerForm = function(f, formEl) {
	var form = formEl || document.forms[f];
	if (typeof(AH.VARIABLE_MAP[f]) == "undefined")
		AH.VARIABLE_MAP[f] = {};
    AH.COLLECTIONS_MAP[f] = {};
	if ( typeof(form) == 'undefined' ) return;
	for ( var i = 0; i < form.length; i++ ) {
		var el = form[i];
		if ( el != null && el.value != null && el.id != null && el.id != "")
        {
            //Check for collections
            if (el.type && el.type == "text" && Dom.getAncestorByClassName(el, "emailaddresses"))
            {
                //Find the parent span to get the field name
                var span = Dom.getAncestorByTagName(el, "span");
                    sId = span.id; //Will be in the format fieldName_span
                    fieldName = sId.substring(0, sId.length - 5);
                if (!AH.VARIABLE_MAP[f][fieldName] || !Dom.isAncestor(span, AH.VARIABLE_MAP[f][fieldName])) {
                    AH.VARIABLE_MAP[f][fieldName] = el;
                    AH.updateListeners(fieldName, f, el);
                }
                } else if(el.type && el.type == "radio") {
                    if (!AH.COLLECTIONS_MAP[f][el.name]) {
                        AH.COLLECTIONS_MAP[f][el.name] = [];
                    }
                AH.COLLECTIONS_MAP[f][el.name].push(el);
            }
			AH.VARIABLE_MAP[f][el.id] = el;
            AH.updateListeners(el.id, f, el);
        }
		else if ( el != null && el.value && el.type=="hidden"){
			AH.VARIABLE_MAP[f][el.name] = el;
			AH.updateListeners(el.name, f, el);
		}
	}
}

AH.registerView = function(view, startEl) {
	var Dom = YAHOO.util.Dom;
	AH.lastView = view;
	if (typeof(AH.VARIABLE_MAP[view]) == "undefined")
		AH.VARIABLE_MAP[view] = {};
	if (Dom.get(view) != null && Dom.get(view).tagName == "FORM") {
		return AH.registerForm(view);
	}
	var form = Dom.get("form");
    if (form && form.name == view)
    {
        AH.registerForm(view, form);
    }
    var nodes = YAHOO.util.Selector.query("span.sugar_field", startEl);
	for (var i in nodes) {
		if (nodes[i].id != "")
			AH.VARIABLE_MAP[view][nodes[i].id] = nodes[i];
            AH.updateListeners(nodes[i].id, view, nodes[i]);
	}
}


/**
 * @STATIC
 * Register a form field with the handler.
 */
AH.registerField = function(formname, field) {
	AH.registerFields({form:formname,fields:new Array(field)});
}

/**
 * @STATIC
 * Retrieve the value of a variable.
 */
AH.getValue = function(variable, view, ignoreLinks) {
	if (!view) view = AH.lastView;

	//Relate fields are only string on the client side, so return the variable name back.
	if(AH.LINKS[view][variable] && !ignoreLinks)
		return variable;

	var field = AH.getElement(variable, view);
	if ( field == null || field.tagName == null) 	return null;

	if (field.children.length == 1 && field.children[0].tagName.toLowerCase() == "input")
		field = field.children[0];

	// special select case for IE6 and dropdowns
	if ( field.tagName.toLowerCase() == "select" ) {
		if(field.selectedIndex == -1) {
			return null;
		} else {
			return field.options[field.selectedIndex].value;
		}
	}

	//checkboxes need to return a boolean value
	if(field.tagName.toLowerCase() == "input" && field.type.toLowerCase() == "checkbox") {
		return field.checked ? SUGAR.expressions.Expression.TRUE : SUGAR.expressions.Expression.FALSE;
	}

    if(field.tagName.toLowerCase() == 'input' && field.type.toLowerCase() == 'radio') {
        var form = field.form;
        var radioButtons = form[field.name];

        for(var rbi=0; rbi < radioButtons.length; rbi++) {
            var button = radioButtons[rbi];

            if(button.checked) {
                return button.value;
            }
        }
     }

	//Special case for dates
	if (field.className && (field.className == "DateTimeCombo" || field.className == "Date")){
		return SUGAR.util.DateUtils.parse(field.value, "user");
	}

	//For DetailViews where value is enclosed in a span tag
    if (field.tagName.toLowerCase() == "span")
    {
        if (field.hasAttribute("data-id-value"))
        {
            return field.getAttribute("data-id-value");
        }

        return document.all ? trim(field.innerText) : trim(field.textContent);
    }

	if (field.value !== null && typeof(field.value) != "undefined")
	{
		var asNum = SUGAR.expressions.unFormatNumber(field.value);
		if ( (/^(\-)?[0-9]+(\.[0-9]+)?$/).exec(asNum) != null ) {
			return parseFloat(asNum);
		}
		return field.value;
	}

	return YAHOO.lang.trim(field.innerText);
}

/**
 * @STATIC
 * Retrieve the element behind a variable.
 */
AH.getLink = function(variable, view) {
	if (!view) view = AH.lastView;

	if(AH.LINKS[view][variable])
		return AH.LINKS[view][variable];
}

/**
 *
 * @param link
 * @param type
 * @param field
 * @param value
 * @param view
 */
AH.cacheRelatedField = function(link, ftype, value, view)
{
    if (!view) view = AH.lastView;

    if(!AH.LINKS[view][link])
        return false;

    //If there is already a value cached for this link, we need to merge in the new field values
    if (typeof(AH.LINKS[view][link][ftype]) == "object" && typeof(value == "object"))
    {
        for(var i in value)
        {
            AH.LINKS[view][link][ftype][i] = value[i];
        }
    }
    else
        AH.LINKS[view][link][ftype] = value;

    return true;
}

/**
 *
 * @param link
 * @param ftype
 * @param view
 */
AH.getCachedRelatedField = function(link, ftype, view)
{
    if (!view) view = AH.lastView;

    if(!AH.LINKS[view][link] || AH.LINKS[view][link][ftype])
        return null;

    return AH.LINKS[view][link][ftype];
}

 /**
  * @STATIC
 * Retrieve the collection behind a variable.
 */
AH.getCollection = function (variable, view) {
    if (!view)view = AH.lastView;
        var field = (AH.COLLECTIONS_MAP[view] && AH.COLLECTIONS_MAP[view][variable]) ? AH.COLLECTIONS_MAP[view][variable] : null;
        return field;
}

/**
 * @STATIC
 * Retrieve the element behind a variable.
 */
AH.getElement = function(variable, view) {
	if (!view) view = AH.lastView;

	// retrieve the variable
	var field = AH.VARIABLE_MAP[view][variable];

	if ( field == null )
		field = YAHOO.util.Dom.get(variable);

	return field;
}

/**
 * @STATIC
 * Assign a value to a variable.
 */
AH.assign = function(variable, value, flash)
{
	var Dom = YAHOO.util.Dom;
	if (typeof flash == "undefined")
		flash = true;
	// retrieve the variable
	var field = AH.getElement(variable);

	if ( field == null )
		return null;

	// now check if this field is locked
	if ( AH.LOCKS[variable] != null ) {
		throw ("Circular Reference Detected");
	}

	//Detect field types and add error handling.
    if (document.DetailView)
    {
        field.innerHTML = '';
        field.appendChild(document.createTextNode(value));
    }
    else if (Dom.hasClass(field, "imageUploader"))
	{
		var img = Dom.get("img_" + field.id);
		img.src = value;
		img.style.visibility = "";
	}
	else if (field.type == "checkbox") {
		field.checked = value == SUGAR.expressions.Expression.TRUE || value === true;
	}
    else if(field.type == "radio") {//52997 - select radio button
        var radioButtons = field.form[field.id];

        for(var rbi=0; rbi < radiobuttons.length; rbi++) {
            var button = radioButtons[rbi];

            if(button.value == value) {
                button.checked = true;
            } else {
                button.checked = false;
            }
        }
    }
    else if(value instanceof Date)
    {
        if (Dom.hasClass(field, "date_input"))
			field.value = SUGAR.util.DateUtils.formatDate(value);
		else {
            if (Dom.hasClass(field, "DateTimeCombo"))
                AH.setDateTimeField(field, value);

            field.value = SUGAR.util.DateUtils.formatDate(value, true);
        }
    }
	else {
        // See if this is a numeric field that needs formatting
        var fieldForm = field.form.attributes.name.value;
        var fieldType = 'text';
        
        if ( typeof(validate[fieldForm]) == "object" ) {
            for ( var idx in validate[fieldForm] ) {
                if (validate[fieldForm][idx][0] == field.name) {
                    // We found our field
                    fieldType = validate[fieldForm][idx][1];
                    break;
                }
            }
        }
        if ( fieldType == 'decimal' || fieldType == 'currency' || fieldType == 'int' ) {
            // It's numeric, let's format it
            var localPrecision = 2;
            if ( fieldType == 'int' ) {
                localPrecision = 0;
            } else {
                // Some pages actually populate the precision, most do not however.
                if ( typeof(precision) != 'undefined' ) {
                    localPrecision = precision;
                }
            }

            if ( value != '' ) {
                value = formatNumber(value,num_grp_sep,dec_sep,localPrecision,localPrecision);
            }
        } else if ( typeof(value) == 'object' 
                    && value.length > 0 
                    && fieldType != 'multienum' ) {
            value = value.join(', ');
        }
		field.value = value;
	}

	// animate
	if ( AH.ANIMATE && flash){
        try{
            //This can throw an error if the page is in the middle of rendering
            SUGAR.forms.FlashField(field);
        }catch(e){}
    }


	// lock this variable
	AH.LOCKS[variable] = true;

	// fire onchange
	SUGAR.util.callOnChangeListers(field);

	// unlock this variable
	AH.LOCKS[variable] = null;
}

/**
 * @private
 *  Private function used to attach a listener to an element
 *
 * @param varname
 * @param callback
 * @param scope
 */
var attachListener = function(el, callback, scope, view)
{
    scope = scope || this;
    if (el.type && el.type.toUpperCase() == "CHECKBOX")
    {
        return YAHOO.util.Event.addListener(el, "click", callback, scope, true);
    }
    else if (el.type && el.type.toUpperCase() == "RADIO"){//52997 - add event listners on Radio button elements
        var radioButtons = el.form[el.id];

        for(var radioButtonIndex = 0; radioButtonIndex < radioButtons.length; radioButtonIndex++) {
            var button = radioButtons[radioButtonIndex];
            YAHOO.util.Event.addListener(button, "click", callback, scope, true);
        }
    }
    else {
        return YAHOO.util.Event.addListener(el, "change", callback, scope, true);
    }
}

/**
 *  Registers a callback to fire when a variable/field changes in the current view
 * @param varname
 * @param callback
 * @param scope
 * @param view
 */
AH.addListener = function(varname, callback, scope, view)
{
    if (!view) view = AH.lastView;
    if (!AH.LISTENERS[view]) AH.LISTENERS[view] = {};
    if (!AH.LISTENERS[view][varname]) AH.LISTENERS[view][varname] = [];
    var el = AH.getElement(varname, view);
    AH.LISTENERS[view][varname].push({el:el, callback:callback, scope:scope});
    if (!el) return false;
    attachListener(el, callback, scope, view);
}

/**
 *  re-attach any listeners orhpaned for a given variable on a given view (such as a field being removed and then re-added
 * @param varname
 * @param view
 */
AH.updateListeners = function(varname, view, el)
{
    if (!view) view = AH.lastView;
    if (!AH.LISTENERS[view] || !AH.LISTENERS[view][varname] ) {
        return;
    }
    var l = AH.LISTENERS[view][varname],
        el = el || AH.getElement(varname, view);

    for(var i =0; i < l.length; i++)
    {
        var oldEl = l[i].el;
        //If the element attached to this event is no longer the current
        // element for this variable on this view, update it
        if (oldEl != el)
        {
            if (oldEl.type && oldEl.type.toUpperCase() == "CHECKBOX")
            {
                YAHOO.util.Event.removeListener(oldEl, "click", l[i].callback);
            }
            else {
                YAHOO.util.Event.removeListener(oldEl, "change", l[i].callback);
            }
            attachListener(el, l[i].callback, l[i].scope, view);
            AH.LISTENERS[view][varname][i] = {el:el, callback:l[i].callback, scope:l[i].scope};
        }
    }

}

AH.setDateTimeField = function(field, value)
{
	var Dom = YAHOO.util.Dom,
		SDU = SUGAR.util.DateUtils,
		id = field.id,
	    date = Dom.get(id + "_date"),
		hours = Dom.get(id + "_hours"),
		min = Dom.get(id + "_minutes"),
		mer = Dom.get(id + "_meridiem");

	value = SDU.roundTime(value);
	date.value = SDU.formatDate(value);
	if (mer){
		//set AM/PM field
		var h = SDU.formatDate(value, true, "h");
		var m = SDU.formatDate(value, true, "i");
		var a = SUGAR.expressions.userPrefs.timef.indexOf("A") != -1 ?
				SDU.formatDate(value, true, "A") : SDU.formatDate(value, true, "a");
		AH.setSelectedOption(hours, h);
		AH.setSelectedOption(min, m);
		AH.setSelectedOption(mer, a);
	} else {
		//24 Hour time
		var h = SDU.formatDate(value, true, "H");
		var m = SDU.formatDate(value, true, "i");
		AH.setSelectedOption(hours, h);
		AH.setSelectedOption(min, m);
	}
}

AH.setSelectedOption = function(field, value)
{
	for (var i = 0; i < field.options.length; i++)
	{
		if (field.options[i].value == value)
		{
			field.options[i].selected = true;
			break;
		}
	}
	return;
}

AH.showError = function(variable, error)
{
	// retrieve the variable
	var field = AH.getElement(variable);

	if ( field == null )
		return null;

	add_error_style(field.form.name, field, error, false);
}

AH.clearError = function(variable)
{
	// retrieve the variable
	var field = AH.getElement(variable);
	if ( field == null )
		return;

	for(var i in inputsWithErrors)
	{
		if (inputsWithErrors[i] == field)
		{
			if ( field.parentNode.className.indexOf('x-form-field-wrap') != -1 )
            {
				field.parentNode.parentNode.removeChild(field.parentNode.parentNode.lastChild);
            }
            else
            {
            	field.parentNode.removeChild(field.parentNode.lastChild);
            }
			delete inputsWithErrors[i];
			return;
		}
	}
}

AH.fireOnLoad = function(dep)
{
    AH.QUEUEDDEPS.push(dep);
}

AH.loadComplete = function()
{
    // First get a list of all the related values we are going to need,
    // request those from the server, and then fire all the queued dependencies
    var fields = [];
    for (var i = 0; i < AH.QUEUEDDEPS.length; i++)
    {
        fields = $.merge(fields, AH.QUEUEDDEPS[i].getRelatedFields());
    }

    AH.getRelatedFieldValues(fields);

    //Now fire all the queued dependencies
    for (var i = 0; i < AH.QUEUEDDEPS.length; i++)
    {
        SUGAR.forms.Trigger.fire.call(AH.QUEUEDDEPS[i].trigger);
    }
    AH.AFTER_LOAD_COMPLETE.fire();
}

/**
 * This function is used to cache a large set of related fields values at once.
 * @param fields
 */
AH.setRelatedFields = function(fields){
    for (var link in fields)
    {
        for (var type in fields[link])
        {
            AH.cacheRelatedField(link, type, fields[link][type]);
        }
    }
}

/**
 * Send a request to the server to retrieve the value of a related field.
 * @param array fields set of related field values to retrieve. The array should be objects in the format
 *  {
 *      link: "name_of_link_field,"
 *      type: (related, count, rollup*),
 *      relate: "name_of_related_field" (only required for related fields, not rollup or count)
 *  }
 */
AH.getRelatedFieldValues = function(fields, module, record)
{
    if (fields.length > 0){
        module = module || SUGAR.forms.AssignmentHandler.getValue("module") || DCMenu.module;
        record = record || SUGAR.forms.AssignmentHandler.getValue("record") || DCMenu.record;

        // Go from the back, because of the possible deletion of related type fields
        for (var i = fields.length - 1; i >= 0; i--)
        {
            //Related fields require a current related id
            if (fields[i].type == "related")
            {
                var linkDef = SUGAR.forms.AssignmentHandler.getLink(fields[i].link);
                if (linkDef && linkDef.id_name && linkDef.module) {
                    var idField = document.getElementById(linkDef.id_name);
                    if (idField && (idField.tagName == "INPUT" || idField.hasAttribute("data-id-value")))
                    {
                        fields[i].relModule = linkDef.module;
                        fields[i].relId = SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name, false, true);

                        // If there is no relId, there is no point in querying for this field
                        if (fields[i].relId.length == 0)
                        {
                            // So we remove it
                            fields.splice(i, 1);
                        }
                    }
                }
            }
        }

        // If we removed all fields (related) no point in sending a request
        if (fields.length > 0)
        {
            var r = http_fetch_sync("index.php", SUGAR.util.paramsToUrl({
                module:"ExpressionEngine",
                action:"getRelatedValues",
                record_id: record,
                tmodule: module,
                fields: YAHOO.lang.JSON.stringify(fields),
                to_pdf: 1
            }));
            try {
                var ret = YAHOO.lang.JSON.parse(r.responseText);
                AH.setRelatedFields(ret);
                return ret;
            } catch(e){}
        }
    }

    return null;
}

/**
 * Used to retrieve a single related field value, either from the cache or from the server.
 * @param link
 * @param type
 * @param field
 * @param view
 */
AH.getRelatedField = function(link, ftype, field, view){
    if (!view)
        view = AH.lastView;
    else
        AH.lastView = view;


    if(!AH.LINKS[view][link])
        return null;

    var linkDef = SUGAR.forms.AssignmentHandler.getLink(link);
    var currId;
    if (linkDef.id_name)
    {
        currId = SUGAR.forms.AssignmentHandler.getValue(linkDef.id_name, false, true);
    }

    // Clear the Link cache when the old and new relIds are different
    if ((linkDef.relId || currId) && linkDef.relId != currId) {
        AH.clearRelatedFieldCache(link, view);
    }

    if (typeof(linkDef[ftype]) == "undefined"
        || (field && typeof(linkDef[ftype][field]) == "undefined")

        // make sure that at least one of old and new value of the relate field is not empty.
        // otherwise the cache considered invalid in case when both values are empty but have
        // different types (null, false, undefined or empty string)
        || (ftype == "related" && (linkDef.relId || !_.isUndefined(currId)) && linkDef.relId != currId)
    ){
        var params = {link: link, type: ftype};
        if (field)
            params.relate = field;
        AH.getRelatedFieldValues([params]);
        //Reload the link now that getRelatedFieldValues has been called.
        linkDef = SUGAR.forms.AssignmentHandler.getLink(link);
    }

    if (typeof(linkDef[ftype]) == "undefined")
        return null;
    //Everything but count requires specifying a related field to use, so make sure to check that field retrieved correctly
    if (field) {
        //If we didn't load the field we wanted, return null
        if (typeof(linkDef[ftype][field]) == "undefined")
            return null;
        else
            return linkDef[ftype][field];
    }

    return linkDef[ftype];

}

/**
 * When a relate field changes id, we need to clear the cache for that link.
 * @param link
 * @param view
 */
AH.clearRelatedFieldCache = function(link, view){
    if (!view) view = AH.lastView;

    if(!AH.LINKS[view][link])
        return false;

    delete (AH.LINKS[view][link]["relId"]);
    delete (AH.LINKS[view][link]["related"]);

    return true;
}

/**
 * @STATIC
 * Change the style attributes of the given variable.
 */
AH.setStyle = function(variable, styles)
{
	// retrieve the variable
	var field = AH.getElement(variable);
	if ( field == null )	return null;

	// set the styles
	for ( var property in styles ) {
		YAHOO.util.Dom.setStyle(field, property + "", styles[property]);
	}
}

/**
 * Resets all of the SugarLogic Form Handler variables and registers to clean any cruft from previously loaded views.
 */
AH.reset = function() {
    AH.VARIABLE_MAP = {};
    AH.LISTENERS = {};
    AH.LINKS = {};
    AH.LOCKS = {};
}

SUGAR.forms.FormExpressionContext = function(formName)
{
	this.formName = formName;
	if (typeof(AH.VARIABLE_MAP[formName]) == "undefined")
		AH.registerView(formName);
}

SUGAR.util.extend(SUGAR.forms.FormExpressionContext, SUGAR.expressions.ExpressionContext, {
	getValue: function(varname)
	{
		var SE = SUGAR.expressions, toConst = SE.ExpressionParser.prototype.toConstant;

		var value = "";

		//Relate fields are only string on the client side, so return the variable name back.
		if(AH.LINKS[this.formName][varname])
			value = varname;
		else
			value = AH.getValue(varname, this.formName);

        if(typeof(value) == 'number')
        {
            return toConst(value);
        }
		else if (typeof(value) == "string")
		{
			if ((/^(\s*)$/).exec(value) != null || value === "")
            {
				return toConst('""')
			}
            // test if value is a number or boolean
            else if ( SE.isNumeric(value) ) {
				return toConst(SE.unFormatNumber(value));
		    }
			// assume string
			else {
				return toConst('"' + value + '"');
			}
		} else if (typeof(value) == "object" && value != null && value.getTime) {
			//This is probably a date object that we must convert to an expression
			var d = new SE.DateExpression("");
			d.evaluate = function(){return this.value};
			d.value = value;
			return d;
		}


		return toConst('""');
	},
	setValue: function(varname, value)
	{
		AH.assign(varname, value, true);
	},
    getLink : function(varname)
    {
        if(AH.LINKS[this.formName][varname])
            return AH.LINKS[this.formName][varname];
        return false;
    },
    addListener : function(varname, callback, scope)
    {
    	AH.addListener(varname, callback, scope, this.formName);
    },
    getRelatedField : function(link, ftype, field){
        //For 'related' fields, the ID of the related record can be changed on the form so we need to look for it
        //before we call down to the server
        if (ftype == 'related')
        {
            //We just have a field name, assume its the name of a link field
            //and the parent module is the current module.
            //Try and get the current module and record ID
            var module = AH.getValue("module");
            var record = AH.getValue("record");
            var linkDef = AH.getLink(link);
            var linkId = false, url = "index.php?";

            if (linkDef && linkDef.id_name && linkDef.module) {
                var idField = document.getElementById(linkDef.id_name);
                if (idField && idField.tagName == "INPUT")
                {
                    linkId = AH.getValue(linkDef.id_name, false, true);
                    module = linkDef.module;
                }
                //Clear the cache for this link if the id has changed
                if (linkDef.relId && linkDef.relId != linkId)
                    AH.clearRelatedFieldCache(link);
            }
        }

        return AH.getRelatedField(link, ftype, field);
    },
    getAppListStrings : function(list) {
        return SUGAR.language.get('app_list_strings', list);
    },
    parseDate: function(date, type) {
        return SUGAR.util.DateUtils.parse(date, type);
    },
    getElement : function(variable) {
        return AH.getElement(variable, this.formName);
    },

    /**
     * Do math calculations in javascript,
     * sans floating point errors.
     *
     * ex. $10.52 is really 1052 cents. Think of currency as
     * cents and apply math that way (as integers)  and this should
     * help keep floating point issues out of the picture.
     *
     * @param {String} operator
     * @param {Number} n1
     * @param {Number|undefined} n2
     * @param {Number|undefined} (decimals)
     * @param {boolean|undefined} (fixed) return value as fixed string
     * @return {Number|String} rounded amount
     */
    _math: function(operator, n1, n2, decimals, fixed) {
        decimals = (_.isFinite(decimals) && decimals >= 0) ? parseInt(decimals) : 6;
        fixed = fixed || false;
        var result;
        var divisor = Math.pow(10, decimals);
        var r1 = parseFloat(n1) * divisor;
        var r2 = !_.isUndefined(n2) ? (parseFloat(n2) * divisor) : undefined;
        switch (operator) {
            case 'round':
                result = Math.round(r1) / divisor;
                break;
            case 'add':
                result = (r1 + r2) / divisor;
                break;
            case 'sub':
                result = (r1 - r2) / divisor;
                break;
            case 'mul':
                result = this.round(r1 * r2 / divisor / divisor, decimals, fixed);
                break;
            case 'div':
                result = this.round(r1 / r2, decimals, fixed);
                break;
            default:
                // no valid operator, just return number
                return n1;
                break;
        }
        return (fixed && !_.isString(result)) ? result.toFixed(decimals) : result;
    },
    /**
     * Used to Add Values
     *
     * @param {String|Number} start        What we are starting with
     * @param {String|Number} add          What we want to add to the value
     * @return {String}
     */
    add: function(start, add) {
        return this._math('add', start, add, 6, true);
    },
    /**
     * Used to Subtract Values
     *
     * @param {String|Number} start        What we are starting with
     * @param {String|Number} subtract          What we want to subtract from the value
     * @return {String}
     */
    subtract: function(start, subtract) {
        return this._math('sub', start, subtract, 6, true);
    },
    /**
     * Used to Multiply Values
     *
     * @param {String|Number} start        What we are starting with
     * @param {String|Number} multiply     What we want to multipy by
     * @return {String}
     */
    multiply: function(start, multiply) {
        return this._math('mul', start, multiply, 6, true);
    },
    /**
     * Used to Divide Values
     *
     * @param {String|Number} start        What we are starting with
     * @param {String|Number} divide       What we want to divide the currency value by
     * @return {String}
     */
    divide: function(start, divide) {
        return this._math('div', start, divide, 6, true);
    },
    /**
     * Used to Round Values
     *
     * @param {String|Number} start        What we are starting with
     * @param {String|Number} divide       What we want to divide the currency value by
     * @return {String}
     */
    round: function(start, precision) {
        return this._math('round', start, precision, true);
    }
});


/**
 * @STATIC
 * The Default expression parser.
 */
SUGAR.forms.DefaultExpressionParser = new SUGAR.expressions.ExpressionParser();

/**
 * @STATIC
 * Parses expressions given a variable map.<br>
 */
SUGAR.forms.evalVariableExpression = function(expression, varmap, view)
{
	return SUGAR.forms.DefaultExpressionParser.evaluate(expression, new SUGAR.forms.FormExpressionContext(view));

	if (!view) view = AH.lastView;
	var SE = SUGAR.expressions;
	// perform range replaces
	expression = SUGAR.forms._performRangeReplace(expression);

	var handler = AH;

	// resort to the master variable map if not defined
	if ( typeof(varmap) == 'undefined' )
	{
		varmap = new Array();
		for ( v in AH.VARIABLE_MAP[view]) {
			if (v != "") {
				varmap[varmap.length] = v;
			}
		}
	}

	if ( expression == SE.Expression.TRUE || expression == SE.Expression.FALSE )


	var vars = SUGAR.forms.getFieldsFromExpression(expression);
	for (var i in vars)
	{
		var v = vars[i];
		var value = AH.getValue(v);
		if (value == null) {
			continue;
			//throw "Unable to find field: " + v;
		}

		var regex = new RegExp("\\$" + v, "g");

		if (value === null)
        {
            value = "";
        }
        if (typeof(value) == "string")
		{
			value = value.replace(/\n/g, "");
			if ((/^(\s*)$/).exec(value) != null || value === "")
            {
			expression = expression.replace(regex, '""');		}
            // test if value is a number or boolean
            else if ( SE.isNumeric(value) ) {
                expression = expression.replace(regex, SE.unFormatNumber(value));
		    }
			// assume string
			else {
				expression = expression.replace(regex, '"' + value + '"');
			}
		} else if (typeof(value) == "object" && value.getTime) {
			//This is probably a date object that we must convert to a string first.
			value = "date(" + value.getTime() + ")";
			expression = expression.replace(regex, value);
		}



	}

	return SUGAR.forms.DefaultExpressionParser.evaluate(expression);
}

/**
 * Replaces range expressions with their values.
 * eg. '%a[1,10]' => '$a1,$a2,$a3,...,$a10'
 */
SUGAR.forms._performRangeReplace = function(expression)
{
	this.generateRange = function(prefix, start, end) {
		var str = "";
		var i = parseInt(start);
		if ( typeof(end) == 'undefined' )
			while ( AH.getElement(prefix + '' + i) != null )
				str += '$' + prefix + '' + (i++) + ',';
		else
			for ( ; i <= end ; i ++ ) {
				var t = prefix + '' + i;
				if ( AH.getElement(t) != null )
					str += '$' + t + ',';
			}
		return str.substring(0, str.length-1);
	}

	this.valueReplace = function(val) {
		if ( !(/^\$.*$/).test(val) )	return val;
		return AH.getValue(val.substring(1));
	}

	// flags
	var isInQuotes = false;
	var prev;
	var inRange;

	// go character by character
	for ( var i = 0 ;  ; i ++ ) {
		// due to fluctuating expression length
		if ( i == expression.length ) break;

		var ch = expression.charAt(i);

		if ( ch == '"' && prev != '\\' )	isInQuotes = !isInQuotes;

		if ( !isInQuotes && ch == '%' ) {
			inRange = true;

			// perform the replace
			var loc_start = expression.indexOf( '[' , i+1 );
			var loc_comma = expression.indexOf(',', loc_start );
			var loc_end   = expression.indexOf(']', loc_start );

			// invalid expression syntax?
			if ( loc_start < 0 || loc_end < 0 )	throw ("Invalid range syntax");

			// construct the pieces
			var prefix = expression.substring( i+1 , loc_start );
			var start, end;

			// optional param is there
			if ( loc_comma > -1 && loc_comma < loc_end ) {
				start = expression.substring( loc_start+1, loc_comma );
				end = expression.substring( loc_comma + 1, loc_end );
			} else {
				start = expression.substring( loc_start+1, loc_end );
			}

			// optional param is there
			if ( loc_comma > -1 && loc_comma < loc_end )	end = expression.substring( loc_comma + 1, loc_end );

			// construct the range
			var result = this.generateRange(prefix, this.valueReplace(start), this.valueReplace(end));
			//var result = this.generateRange(prefix, start, end);

			// now perform the replace
			if ( typeof(end) == 'undefined' )
				expression = expression.replace('%'+prefix+'['+start+']', result);
			else
				expression = expression.replace('%'+prefix+'['+start+','+end+']', result);

			// skip on
			i = i + result.length - 1;
		}

		prev = ch;
	}

	return expression;
}

SUGAR.forms.getFieldsFromExpression = function(expression)
{
	var re = /[^$]*?\$(\w+)[^$]*?/g,
		matches = [],
		result;
	while (result = re.exec(expression))
	{
		matches.push(result[result.length-1]);
	}
	return matches;
}

/**
 * A dependency is an object representation of a variable being dependent
 * on other variables. For example A being the sum of B and C where A is
 * 'dependent' on B and C.
 */
SUGAR.forms.Dependency = function(trigger, actions, falseActions, testOnLoad, form)
{
	if (typeof(form) != "string")
		if (AH.lastView)
			form = AH.lastView;
		else
			form = "EditView";
	this.actions = actions;
	this.falseActions = falseActions;
	this.context = new SUGAR.forms.FormExpressionContext(form);
    trigger.setContext(this.context);
    trigger.setDependency(this);
	SUGAR.lastDep = this;
    this.trigger = trigger;
	if (testOnLoad) {
			AH.fireOnLoad(this);
	}

}


/**
 * Triggers this dependency to be re-evaluated again.
 */
SUGAR.forms.Dependency.prototype.fire = function(undo)
{
	try {
		var actions = this.actions;
		if (undo && this.falseActions != null)
			actions = this.falseActions;

		if (actions instanceof SUGAR.forms.AbstractAction) {
			actions.setContext(this.context);
			actions.exec();
		} else {
			for (var i in actions) {
				var action = actions[i];
				if (typeof action.exec == "function") {
					action.setContext(this.context);
					action.exec();
				}
			}
		}
	} catch (e) {
		if (!SUGAR.isIE && console && console.log){
			console.log('ERROR: ' + e);
		}
		return;
	}
};

SUGAR.forms.Dependency.prototype.getRelatedFields = function () {
    var parser = SUGAR.forms.DefaultExpressionParser,
        fields = parser.getRelatedFieldsFromFormula(this.trigger.condition);
    //parse will search a list of actions for formulas with relate fields
    var parse = function (actions) {
        if (actions instanceof SUGAR.forms.AbstractAction) {
            actions = [actions];
        }
        for (var i in actions) {
            var action = actions[i];
            //Iterate over all the properties of the action to see if they are formulas with relate fields
            if (typeof action.exec == "function") {
                for (var p in action) {
                    if (typeof action[p] == "string")
                        fields = $.merge(fields, parser.getRelatedFieldsFromFormula(action[p]));
                }
            }
        }
    }
    parse(this.actions);
    parse(this.falseActions);
    return fields;
}


    SUGAR.forms.AbstractAction = function (target) {
        this.target = target;
    };

    SUGAR.forms.AbstractAction.prototype.exec = function () {

    }

    SUGAR.forms.AbstractAction.prototype.setContext = function (context) {
        this.context = context;
    }

    SUGAR.forms.AbstractAction.prototype.evalExpression = function (exp, context) {
        return SUGAR.forms.DefaultExpressionParser.evaluate(exp, context).evaluate();
    }

    /**
     * This object resembles a trigger where a change in any of the specified
     * variables triggers the dependencies to be re-evaluated again.
     */
    SUGAR.forms.Trigger = function (variables, condition) {
        this.variables = variables;
        this.condition = condition;
        this.dependency = { };
        this._attachListeners();
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype._attachListeners = function () {
        var handler = AH;
        if (!(this.variables instanceof Array)) {
            this.variables = [this.variables];
        }

        for (var i = 0; i < this.variables.length; i++) {
            var el = handler.getCollection(this.variables[i]);
            if(!el) {
                var el = handler.getElement(this.variables[i]);
            }
            if (!el) continue;
            if (el.type && el.type.toUpperCase() == "CHECKBOX") {
                YAHOO.util.Event.addListener(el, "click", SUGAR.forms.Trigger.fire, this, true);
            } else {
                YAHOO.util.Event.addListener(el, "change", SUGAR.forms.Trigger.fire, this, true);
            }
        }
    }

    /**
     * Attaches a 'change' listener to all the fields that cause
     * the condition to be re-evaluated again.
     */
    SUGAR.forms.Trigger.prototype.setDependency = function (dep) {
        this.dependency = dep;
    }

    SUGAR.forms.Trigger.prototype.setContext = function (context) {
        this.context = context;
    }

    /**
     * @STATIC
     * This is the function that is called when a 'change' event
     * is triggered. If the condition is true, then it triggers
     * all the dependencies.
     */
    SUGAR.forms.Trigger.fire = function () {
        // eval the condition
        var eval;
        var val;
        try {
            eval = SUGAR.forms.DefaultExpressionParser.evaluate(this.condition, this.context);
        } catch (e) {
            if (!SUGAR.isIE && console && console.log) {
                console.log('ERROR:' + e + "; in Condition: " + this.condition);
            }
        }

        // evaluate the result
        if (typeof(eval) != 'undefined')
            val = eval.evaluate();

        // if the condition is met
        if (val == SUGAR.expressions.Expression.TRUE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(false);
                return;
            }
        } else if (val == SUGAR.expressions.Expression.FALSE) {
            // single dependency
            if (this.dependency instanceof SUGAR.forms.Dependency) {
                this.dependency.fire(true);
                return;
            }
        }
    }

    SUGAR.forms.flashInProgress = {};
    /**
     * @STATIC
     * Animates a field when by changing it's background color to
     * a shade of light red and back.
     */
    SUGAR.forms.FlashField = function (field, to_color) {
        if (typeof(field) == 'undefined')     return;

        if (SUGAR.forms.flashInProgress[field.id])
            return;
        SUGAR.forms.flashInProgress[field.id] = true;
        // store the original background color
        var original = field.style.backgroundColor;

        // default bg-color to white
        if (typeof(original) == 'undefined' || original == '') {
            original = '#FFFFFF';
        }

        // default to_color
        if (typeof(to_color) == 'undefined')
            var to_color = '#FF8F8F';

        // Create a new ColorAnim instance
        var oButtonAnim = new YAHOO.util.ColorAnim(field, { backgroundColor:{ to:to_color } }, 0.2);

        oButtonAnim.onComplete.subscribe(function () {
            if (this.attributes.backgroundColor.to == to_color) {
                this.attributes.backgroundColor.to = original;
                this.animate();
            } else {
                field.style.backgroundColor = original;
                SUGAR.forms.flashInProgress[field.id] = false;
            }
        });

        //Flash tabs for fields that are not visible.
        var tabsId = field.form.getAttribute("name") + "_tabs";
        if (typeof (window[tabsId]) != "undefined") {
            var tabView = window[tabsId];
            var parentDiv = YAHOO.util.Dom.getAncestorByTagName(field, "div");
            if (tabView.get) {
                var tabs = tabView.get("tabs");
                for (var i in tabs) {
                    if (i != tabView.get("activeIndex") && (tabs[i].get("contentEl") == parentDiv
                        || YAHOO.util.Dom.isAncestor(tabs[i].get("contentEl"), field))) {
                        var label = tabs[i].get("labelEl");

                        if (SUGAR.forms.flashInProgress[label.parentNode.id])
                            return;

                        var tabAnim = new YAHOO.util.ColorAnim(label, { color:{ to:'#F00' } }, 0.2);
                        tabAnim.origColor = Dom.getStyle(label, "color");
                        tabAnim.onComplete.subscribe(function () {
                            if (this.attributes.color.to == '#F00') {
                                this.attributes.color.to = this.origColor;
                                this.animate();
                            } else {
                                SUGAR.forms.flashInProgress[label.parentNode.id] = false;
                            }
                        });
                        SUGAR.forms.flashInProgress[label.parentNode.id] = true;
                        tabAnim.animate();
                    }
                }
            }
        }

        oButtonAnim.animate();
    }
})();

/* End of File include/Expressions/javascript/dependency.js */

/*
     * Your installation or use of this SugarCRM file is subject to the applicable
     * terms available at
     * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
     * If you do not agree to all of the applicable terms or do not have the
     * authority to bind the entity as an authorized representative, then do not
     * install or use this SugarCRM file.
     *
     * Copyright (C) SugarCRM Inc. All rights reserved.
     *//*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

function initPanel(id, state) {
    panelId = 'detailpanel_' + id;
    expandPanel(id);
    if(state == 'collapsed') {
        collapsePanel(id);
    }
}

function expandPanel(id) {
    var panelId = 'detailpanel_' + id;
    document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' expanded';
}

function collapsePanel(id) {
    var panelId = 'detailpanel_' + id;
    document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' collapsed';
}

function setCollapseState(mod, panel, isCollapsed) {
    var sugar_panel_collase = Get_Cookie("sugar_panel_collase");
    if(sugar_panel_collase == null) {
        sugar_panel_collase = {};
    } else {
        sugar_panel_collase = YAHOO.lang.JSON.parse(sugar_panel_collase);
    }
    sugar_panel_collase[mod] = sugar_panel_collase[mod] || {};
    sugar_panel_collase[mod][panel] = isCollapsed;

    Set_Cookie('sugar_panel_collase', YAHOO.lang.JSON.stringify(sugar_panel_collase),30,'/','','');
}

/* End of File include/EditView/Panels.js */

