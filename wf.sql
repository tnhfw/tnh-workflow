-- find start node for workflow
SELECT * FROM wf_node a WHERE a.wf_id = 1 AND a.wf_node_status = 1 AND a.wf_node_type = 1 ;

-- find end node for workflow
SELECT * FROM wf_node a WHERE a.wf_id = 1 AND a.wf_node_status = 1 AND a.wf_node_type = 3 ;

-- check if is user task node 
SELECT * FROM wf_node a 
WHERE a.wf_node_id = 4 
AND a.wf_node_status = 1 
AND a.wf_node_task_type = 1 
AND a.wf_node_type = 2;



-- check if is decision task node 
SELECT * FROM wf_node a 
WHERE a.wf_node_id = 4 
AND a.wf_node_status = 1 
AND a.wf_node_task_type = 2 
AND a.wf_node_type = 2;

-- check if is script task node 
SELECT * FROM wf_node a 
WHERE a.wf_node_id = 4 
AND a.wf_node_status = 1 
AND a.wf_node_task_type = 3 
AND a.wf_node_type = 2;

-- check if is service task node 
SELECT * FROM wf_node a 
WHERE a.wf_node_id = 4 
AND a.wf_node_status = 1 
AND a.wf_node_task_type = 4 
AND a.wf_node_type = 2;


-- find next node after start node
-- c.wf_node_from_id = 1: start node id
SELECT a.wf_node_name from_name, b.wf_node_name to_name, c.wf_node_from_id, c.wf_node_to_id 
FROM wf_node a, wf_node b, wf_node_path c 
WHERE a.wf_node_id = c.wf_node_from_id
AND b.wf_node_id = c.wf_node_to_id
AND  c.wf_node_from_id = 1
AND a.wf_node_type = 1
AND b.wf_node_task_type IN (1,3,4);



-- find next node
-- c.wf_node_from_id = 1: from node id
SELECT a.wf_node_name from_name, b.wf_node_name to_name, c.wf_node_from_id, c.wf_node_to_id 
FROM wf_node a, wf_node b, wf_node_path c 
WHERE a.wf_node_id = c.wf_node_from_id
AND b.wf_node_id = c.wf_node_to_id
AND  c.wf_node_from_id = 6
AND b.wf_node_type IN (2,3);



-- find if next node is End node
-- c.wf_node_from_id = 1: current node id
SELECT a.wf_node_name from_name, b.wf_node_name to_name, c.wf_node_from_id, c.wf_node_to_id 
FROM wf_node a, wf_node b, wf_node_path c 
WHERE a.wf_node_id = c.wf_node_from_id
AND b.wf_node_id = c.wf_node_to_id
AND  c.wf_node_from_id = 8
AND a.wf_node_type = 2
AND b.wf_node_type = 3;



 
-- find current user/role for node validation
-- c.wf_inst_id = 1: workflow instance id
SELECT d.user_name, b.wf_role_name FROM wf_node a, wf_role b , wf_user_role c, users d, wf_instance e
WHERE a.wf_role_id = b.wf_role_id
AND b.wf_role_id = c.wf_role_id
AND c.user_id = d.user_id
AND c.wf_inst_id = e.wf_inst_id
AND e.wf_inst_state = 'A'
AND a.wf_node_task_type = 1
AND c.wf_inst_id = 1
AND a.wf_node_id = 2;

-- find next node based in node desicion and path condition of User Task
-- c.wf_node_from_id = 1: from node id
SELECT a.wf_node_name from_name, b.wf_node_name to_name, c.wf_node_from_id, c.wf_node_to_id 
FROM wf_node a, wf_node b, wf_node_path c 
WHERE a.wf_node_id = c.wf_node_from_id
AND b.wf_node_id = c.wf_node_to_id
AND  c.wf_node_from_id = 7
AND a.wf_node_task_type = 2
AND a.wf_node_type IN (2,3)
AND c.wf_np_cond_name = 'outcome'
AND c.wf_np_cond_value = 'Y';




-- get task detail
SELECT b.wf_node_name, c.user_name, d.wf_inst_state, d.wf_inst_desc, d.wf_inst_start_date, d.wf_inst_end_date, 
d.wf_inst_entity_id, d.wf_inst_entity_detail, d.wf_inst_start_comment, d.start_by_id,
g.user_name start_user,
e.wf_oc_name,
f.wf_name,
a.*
FROM wf_task a, wf_node b, users c, wf_instance d, wf_node_outcome e, workflow f, users g
WHERE a.wf_inst_id = d.wf_inst_id
AND a.wf_oc_id = e.wf_oc_id
AND a.user_id = c.user_id
AND a.wf_node_id = b.wf_node_id
AND b.wf_id = f.wf_id
AND d.start_by_id = g.user_id
AND a.wf_task_id = 1;

















