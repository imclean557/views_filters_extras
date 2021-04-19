## Views Filters Extas

Adds numeric filter options for highest value (maximum) and lowest value (minimum) in results by using a sub query.

This module re-purposes the "min" and "max" fields in the filter configuration without renaming them. For Highest and Lowest options the field values should be field names to query.

There are 3 possible variations:

**No values**

Leaving both fields blank will select only the Highest or Lowest value and return one result.

For e.g. select "Delta" and "Highest Value" will return only the last delta and no other results, even if the view might otherwise return multiple results.

**Min only**

The field name entered in "min" will be used group the return values using "GROUP BY". For example, if "nid" is entered on a VID filter:

    SELECT MAX(vid) from table_name GROUP BY nid

**Min and Max**

The field names entered in "min" and "max" will be be used with "WHERE" and "=". For example, if "entity_id" and "nid" are entered on a field delta filter:

    SELECT MAX(node__field_hero_images.delta) from node__field_hero_images WHERE entity_id = nid
