Business activity
=================

Overview
--------

Object name: **centreon-bam:BusinessActivity**

Available parameters are the following:

======================= ================================
Parameter                             Description
======================= ================================
**--name**              Business activity name

**--ba-type-id**        Business activity type id

**--level-w**           Warning threshold

**--level-c**           Critical threshold

**--activate**          Enable (0 or 1)

--icon-id               Icon id

--id-reporting-period   Reporting period id
======================= ================================

List
----

In order to list business activities, use **list** action::

  ./centreonConsole centreon-bam:BusinessActivity:list
  id;name;type;description;level_w;level_c
  1;ba1;1;;90;80

Columns are the following:

============= ==============================
Column        Description
============= ==============================
id            Business activity id

name          Business activity name

type          Business activity type

description   Business activity description

level_w       Warning threshold

level_c       Critical threshold
============= ==============================

Show
----

In order to show a business activity, use **show** action::

  ./centreonConsole centreon-bam:BusinessActivity:show --businessactivity=ba1
  id: 4
  name: ba1
  slug: ba1
  description:
  level_w: 90
  level_c: 80
  sla_month_percent_warn:
  sla_month_percent_crit:
  sla_month_duration_warn:
  sla_month_duration_crit:
  id_reporting_period:
  max_check_attempts:
  normal_check_interval:
  retry_check_interval:
  current_level:
  calculate: 0
  downtime: 0
  acknowledged: 0
  must_be_rebuild: 0
  last_state_change:
  current_status:
  in_downtime:
  dependency_dep_id:
  graph_id:
  icon_id:
  graph_style:
  activate: 1
  comment:
  organization_id: 1
  type: 1

Create
------

In order to create a business activity, use **create** action::

  ./centreonConsole centreon-bam:BusinessActivity:create --name=ba1 --ba-type-id=1 --level-w=90 --level-c=80
  Object successfully created

Update
------

In order to update a business activity, use **update** action::

  ./centreonConsole centreon-bam:BusinessActivity:update --businessactivity=ba1 --name=ba2
  Object successfully updated

Delete
------

In order to delete a business activity, use **delete** action::

  ./centreonConsole centreon-bam:BusinessActivity:delete --businessactivity=ba1
  Object successfully deleted

Duplicate (Not yet implemented)
-------------------------------

In order to duplicate a business activity, use **duplicate** action::

  ./centreonConsole centreon-bam:BusinessActivity:duplicate --businessactivity=ba1
  Object successfully duplicated

List tag (Not yet implemented)
------------------------------

In order to list tags of a business activity, use **listTag** action::

  ./centreonConsole centreon-bam:BusinessActivity:listTag --businessactivity=ba1
  tag-ba-1

Add tag (Not yet implemented)
-----------------------------

In order to add a tag to a business activity, use **addTag** action::

  ./centreonConsole centreon-bam:BusinessActivity:addTag --businessactivity=ba1 --tag=tag-ba-1
  The tag has been successfully added to the object

Remove tag (Not yet implemented)
--------------------------------

In order to remove a tag from a business activity, use **removeTag** action::

  ./centreonConsole centreon-bam:BusinessActivity:removeTag --businessactivity=ba1 --tag=tag-ba-1
  The tag has been successfully removed from the object

