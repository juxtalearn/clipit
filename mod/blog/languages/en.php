<?php
/**
 * Blog English language file.
 *
 */

$english = array(
	'blog' => 'Videos',
	'blog:blogs' => 'Videos',
	'blog:revisions' => 'Revisions',
	'blog:archives' => 'Archives',
	'blog:blog' => 'Videos',
	'item:object:blog' => 'Videos',

	'blog:title:user_blogs' => '%s\'s videos',
	'blog:title:all_blogs' => 'All site videos',
	'blog:title:friends' => 'Friends\' videos',

	'blog:group' => 'Group videos',
	'blog:enableblog' => 'Enable group videos',
	'blog:write' => 'Post a video',

	// Editing
	'blog:add' => 'Add video',
	'blog:edit' => 'Edit video',
	'blog:excerpt' => 'Excerpt',
	'blog:body' => 'Body',
	'blog:save_status' => 'Last saved: ',
	'blog:never' => 'Never',

	// Statuses
	'blog:status' => 'Status',
	'blog:status:draft' => 'Draft',
	'blog:status:published' => 'Published',
	'blog:status:unsaved_draft' => 'Unsaved Video',

	'blog:revision' => 'Revision',
	'blog:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'blog:message:saved' => 'Video saved.',
	'blog:error:cannot_save' => 'Cannot save video.',
	'blog:error:cannot_write_to_container' => 'Insufficient access to save video to group.',
	'blog:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'blog:edit_revision_notice' => '(Old version)',
	'blog:message:deleted_post' => 'Video deleted.',
	'blog:error:cannot_delete_post' => 'Cannot delete video.',
	'blog:none' => 'No videos',
	'blog:error:missing:title' => 'Please enter a video title!',
	'blog:error:missing:description' => 'Please enter the description of your video!',
	'blog:error:cannot_edit_post' => 'This video may not exist or you may not have permissions to edit it.',
	'blog:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:blog' => '%s published a video %s',
	'river:comment:object:blog' => '%s commented on the video %s',

	// notifications
	'blog:newpost' => 'A new video',
	'blog:notification' =>
'
%s made a new blog post.

%s
%s

View and comment on the new blog post:
%s
',

	// widget
	'blog:widget:description' => 'Display your latest videos',
	'blog:moreblogs' => 'More videos',
	'blog:numbertodisplay' => 'Number of videos to display',
	'blog:noblogs' => 'No videos'
);

add_translation('en', $english);
