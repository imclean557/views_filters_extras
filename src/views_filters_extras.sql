SELECT opigno_module_relationship.child_id                           AS 
       opigno_module_relationship_child_id, 
opigno_module_field_data_opigno_module_relationship__opigno_module_field_revision.name 
                                                              AS 
       opigno_module_field_data_opigno_module_relationship__opigno_, 
opigno_module_relationship.weight                             AS 
       opigno_module_relationship_weight, 
Max(opigno_module_relationship.omr_id)                        AS omr_id, 
Min(opigno_activity_field_data_opigno_module_relationship.id) AS 
opigno_activity_field_data_opigno_module_relationship_id, 
Min(opigno_module_field_data_opigno_module_relationship.id)   AS 
opigno_module_field_data_opigno_module_relationship_id 
FROM   opigno_module_relationship opigno_module_relationship 
       LEFT JOIN opigno_activity_field_data 
                 opigno_activity_field_data_opigno_module_relationship 
              ON opigno_module_relationship.child_id = 
                 opigno_activity_field_data_opigno_module_relationship.id 
       LEFT JOIN opigno_module_field_data 
                 opigno_module_field_data_opigno_module_relationship 
              ON opigno_module_relationship.parent_id = 
                 opigno_module_field_data_opigno_module_relationship.id 
       INNER JOIN opigno_module_field_revision 
opigno_module_field_data_opigno_module_relationship__opigno_module_field_revision 
        ON opigno_module_field_data_opigno_module_relationship.vid = 
opigno_module_field_data_opigno_module_relationship__opigno_module_field_revision.vid 
WHERE omr_id IN (
    SELECT MAX(omr_id) FROM  opigno_module_relationship GROUP BY child_id
)
GROUP  BY opigno_module_relationship_child_id, 
          opigno_module_field_data_opigno_module_relationship__opigno_, 
          opigno_module_relationship_weight 
ORDER  BY opigno_module_field_data_opigno_module_relationship__opigno_ ASC, 
          opigno_module_relationship_weight ASC; 
