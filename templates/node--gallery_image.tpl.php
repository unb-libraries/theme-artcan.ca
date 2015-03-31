<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */

?>
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if (!$page): ?>
    <header>
      <?php print render($title_prefix); ?>
      <h3<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
      <?php print render($title_suffix); ?>
      <?php /*
        if ($display_submitted): ?>
          <div class="submitted">
            <?php print $submitted; ?>
          </div>
        <?php endif;
            */?>
    </header>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      if ($content['field_gallery']) {
      $gallery_tid = $content['field_gallery']['#items'][0]['taxonomy_term']->tid;
      $gallery_name = taxonomy_term_load($gallery_tid)->name;
      $gallery = taxonomy_term_load($gallery_tid);
      $gallery_path = entity_uri('taxonomy_term', $gallery)['path'];
      $gallery_path_alias = drupal_lookup_path('alias', $gallery_path);
    ?>
    <div class="gallery-return"><a href="<?php echo $gallery_path_alias; ?>">&lt;&lt; Return to <?php echo $gallery_name; ?></a></div>
    <?php
    }
    ?>
    <div class="photo">
      <a href="<?php print file_create_url($content['field_bag_image']['#items'][0]['uri']); ?>" target="_blank"><?php print render($content['field_bag_image']); ?></a>
      <p class="terms">Images, text, and all other content in ArtCan.ca are protected by Canadian and international copyright laws and are intended for non-commercial, educational, promotional and personal research use only. All other uses are expressly prohibited. Requests to reproduce the image on this page should be referred to
      <?php
      if ($content['field_gallery']['#items'][0]['taxonomy_term']->name == 'UNB Art Centre') {
        print 'The UNB Art Centre at (506) 453-4623';
      }
      elseif ($content['field_gallery']['#items'][0]['taxonomy_term']->name == 'Beaverbrook Art Gallery') {
        print '<a href="http://beaverbrookartgallery.org/en/" target="_blank">The Beaverbrook Art Gallery</a>';
      }
      ?>.
      </p>
    </div>
    <div class="field field-type-text-long">
      <div class="field-items">
        <div class="field-item even">
          <p>
            <?php
              $first_name = $content['field_artist']['#items'][0]['taxonomy_term']->field_first_name[$content['field_artist']['#language']][0]['value'];
              $last_name = $content['field_artist']['#items'][0]['taxonomy_term']->field_last_name[$content['field_artist']['#language']][0]['value'];
              $tid = $content['field_artist']['#items'][0]['taxonomy_term']->tid;
            ?>
            <?php print $first_name . " " . $last_name; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="field field-type-text-long">
      <div class="field-items">
        <div class="field-item even">
          <p>
            <?php print $content['field_artist']['#items'][0]['taxonomy_term']->field_nationality[$content['field_artist']['#language']][0]['value']; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="field field-type-text-long">
      <div class="field-items">
        <div class="field-item even">
          <p>
            <?php print $content['field_artist']['#items'][0]['taxonomy_term']->field_life_range[$content['field_artist']['#language']][0]['value']; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="field field-type-text-long">
      <div class="field-items">
        <div class="field-item even">
          <p>
            <?php
            if ($content['field_artwork_title']) {
              print '<em>' . $content['field_artwork_title']['#items'][0]['value'] . '</em>';
            }
            if ($content['field_year']) {
              print ', ' . $content['field_year']['#items'][0]['value'];
            }
            ?>
          </p>
        </div>
      </div>
    </div>
    <?php
      if ($content['field_artwork_type']) {
        print render($content['field_artwork_type']);
      }
      if ($content['field_artwork_dimensions']) {
        print render($content['field_artwork_dimensions']);
      }
      if ($content['field_inscriptions']) {
        print render($content['field_inscriptions']);
      }
      if ($content['field_photography_credit']) {
        print render($content['field_photography_credit']);
      }
      if ($content['field_collection']) {
        print render($content['field_collection']);
      }
      if ($content['field_provenance']) {
        print render($content['field_provenance']);
      }
      if ($content['field_accession_number']) {
        print render($content['field_accession_number']);
    }?>

    <?php
      $bio = $content['field_artist']['#items'][0]['taxonomy_term']->field_bio[$content['field_artist']['#language']][0]['value'];
      if ($bio):
    ?>
    <p class=bio-link>(<a href="biographies/#<?php print $tid; ?>"><?php print t('Biography of'); ?> <?php print $first_name . " " . $last_name; ?></a>)</p>
    <?php endif; ?>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      // print render($content);
    ?>
  </div>
  <?php if ($page): ?>
    <footer>
      <?php print render($content['links']); ?>
      <?php print render($content['comments']); ?>
    </footer>
  <?php endif; ?>

</article>
