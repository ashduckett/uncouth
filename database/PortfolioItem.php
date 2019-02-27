<?php
    require_once('config.php');
    require_once('DBObject.php');
class PortfolioItem extends DataObject implements JSONSerializable {
    protected $data = array(
        "id" => "",
        "title" => "",
        "heading_image_path" => "", 
        "overview_image" => "",
        "detail_images" => "",
        "github_url" => "",
        "rebrand_site_url" => "",
        "actual_site_url" => "",
        "entry_text" => "",
        "detail_text" => ""
    );

    // This will need to be updated for a full insert.
    public function insert() {
        $conn = DataObject::connect();
        $sql = "INSERT INTO " . TBL_PORTFOLIO_ITEM . "( title,  heading_image_path,  overview_image_path,  detail_images,  github_url, rebrand_site_url, actual_site_url, entry_text, detail_text) 
                                                VALUES (:title, :heading_image_path, :overview_image_path, :detail_images, :github_url, :rebrand_site_url, :actual_site_url, :entry_text, :detail_text)";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":title", $this->data["title"], PDO::PARAM_STR);
            $st->bindValue(":heading_image_path", $this->data["heading_image_path"], PDO::PARAM_STR);
            $st->bindValue(":overview_image", $this->data["overview_image"], PDO::PARAM_STR);
            $st->bindValue(":detail_images", $this->data["detail_images"], PDO::PARAM_INT);
            $st->bindValue(":github_url", $this->data["github_url"], PDO::PARAM_STR);
            $st->bindValue(":rebrand_site_url", $this->data["rebrand_site_url"], PDO::PARAM_STR);
            $st->bindValue(":actual_site_url", $this->data["actual_site_url"], PDO::PARAM_STR);
            $st->bindValue(":entry_text", $this->data["entry_text"], PDO::PARAM_STR);
            $st->bindValue(":detail_text", $this->data["detail_text"], PDO::PARAM_STR);
            

            $st->execute();
            // $lastInsertId = $conn->lastInsertId();
            DataObject::disconnect($conn);
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        
        
        return intval($lastInsertId);
    }

    public function update() {
        // This should just update a plain old divesite.
        // At this point we have the data from the form plonked into the DiveSite.
        // We also have the old data.

        // Grab the current value as an array
        $originalLocationsArray = json_encode($this->data['locationImagePaths']);

        $conn = DataObject::connect();

        $sql = 'UPDATE ' . TBL_DIVE_SITE . ' 
            SET heading = :heading, 
                subheading = :subheading,  
                thumbnailPath = :thumbnailPath,
                diverLevel = :diverLevel, 
                rating = :rating, 
                ratingComment = :ratingComment, 
                depth = :depth, 
                visibility = :visibility, 
                current = :current, 
                locationText = :locationText, 
                locationTextTitle = :locationTextTitle,
                locationImagePaths = :locationImagePaths, 
                islands = :islands, 
                virtualTourUrl = :virtualTourUrl,
                isDiveSite = :isDiveSite, 
                presentationOrder = :presentationOrder,
                regions = :regions, 
                isPaid = :isPaid, 
                type = :type,
                isDraft = :isDraft,
                associatedPlaceID = :associatedPlaceID,
                isArchived = :isArchived,
                isSponsored = :isSponsored
            WHERE id = :id;';

        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id", $this->data['id']);
            $st->bindValue(":heading", $this->data['heading']);
            $st->bindValue(":subheading", $this->data['subheading']);
            $st->bindValue(":thumbnailPath", $this->data['thumbnailPath']);
            $st->bindValue(":diverLevel", $this->data['diverLevel']);
            $st->bindValue(":rating", $this->data['rating']);
            $st->bindValue(":ratingComment", $this->data['ratingComment']);
            $st->bindValue(":depth", $this->data['depth']);
            $st->bindValue(":visibility", $this->data['visibility']);
            $st->bindValue(":current", $this->data['current']);
            $st->bindValue(":locationText", $this->data['locationText']);
            $st->bindValue(":locationTextTitle", $this->data['locationTextTitle']);
            $st->bindValue(":locationImagePaths", $this->data['locationImagePaths']);
            $st->bindValue(":islands", $this->data['islands']);
            $st->bindValue(":virtualTourUrl", $this->data['virtualTourUrl']);
            $st->bindValue(":isDiveSite", $this->data['isDiveSite']);
            $st->bindValue(":presentationOrder", $this->data['presentationOrder']);
            $st->bindValue(":regions", $this->data['regions']);
            $st->bindValue(":isPaid", $this->data['isPaid']);
            $st->bindValue(":type", $this->data['type']);
            $st->bindValue(":isDraft", $this->data['isDraft']);
            $st->bindValue(":associatedPlaceID", $this->data['associatedPlaceID']);
            $st->bindValue(":isArchived", $this->data['isArchived']);
            $st->bindValue(":isSponsored", $this->data['isSponsored']);
            $st->execute();
            return true;
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function getAll() {
        $conn = parent::connect();

        $sql = 'SELECT * FROM ' . TBL_PORTFOLIO_ITEM;

        try {
            $st = $conn->prepare($sql);
            $st->execute();

            $portfolioItems = array();

            foreach($st->fetchAll() as $row) {
                $portfolioItems[] = new PortfolioItem($row);
            }
        
            parent::disconnect($conn);
            return $portfolioItems;
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function getFiltered($searchTerm, $islands, $diveSite, $lowerDepth, $upperDepth, $current, $level, $region, $isPaid, $type) {

        $conn = parent::connect();

        $sql = "SELECT * FROM " . TBL_DIVE_SITE . ' WHERE id IS NOT NULL ';

        if ($searchTerm != null) {
            $sql .= 'AND (LOWER(heading) LIKE LOWER(:searchTerm) || LOWER(subheading) LIKE LOWER(:searchTerm) || LOWER(locationText) LIKE LOWER(:searchTerm) || LOWER(locationTextTitle) LIKE LOWER(:searchTerm))';
        }

        if ($islands !== null) {
            $sql .= ' AND LOWER(islands) LIKE LOWER(:islands)';
        }

        if ($diveSite !== null) {
            $sql .= ' AND isDiveSite = :diveSite';
        }

        if($lowerDepth !== null && $upperDepth !== null) {
            $sql .= ' AND depth >= :lowerDepth AND depth <= :upperDepth';
        }

        if ($current !== null) {
            $sql .= ' AND current = :current';
        }
        
        if ($level !== null) {
            $sql .= ' AND diverLevel = :level';
        }

        if ($region !== null) {
            $sql .= ' AND LOWER(regions) LIKE LOWER(:region)';
        }

        if ($type !== null) {
            $sql .= ' AND LOWER(type) LIKE LOWER(:type)';
        }

        if ($isPaid !== null) {
            $sql .= ' AND isPaid = :isPaid';
        }

        $sql .= ' AND isDraft = 0';

        $sql .= ' AND isArchived = 0';

        $sql .= ' ORDER BY presentationOrder';
        try {
            $st = $conn->prepare($sql);
            $searchTerm = '%' . $searchTerm . '%';
            
            if ($region !== null) {
                $region = '%' . $region . '%';
            }

            if ($type !== null) {
                $type = '%' . $type . '%';
            }

            if ($islands !== null) {
                $islands = '%' . $islands . '%';
            }

            if(strlen($searchTerm) > 2) {
                $st->bindValue(":searchTerm", $searchTerm, PDO::PARAM_STR);
            }
            
            if($islands !== null) {
                $st->bindValue(":islands", $islands, PDO::PARAM_STR);
            }


            if($diveSite !== null) {
                $st->bindValue(":diveSite", $diveSite, PDO::PARAM_STR);
            }

            if($current !== null) {
                $st->bindValue(":current", $current, PDO::PARAM_INT);
            }

            if($level !== null) {
                $st->bindValue(":level", $level, PDO::PARAM_INT);
                }

                if($isPaid !== null) {
                $st->bindValue(":isPaid", $isPaid, PDO::PARAM_INT);
                }


            if($lowerDepth !== null && $upperDepth !== null) {
                $st->bindValue(":lowerDepth", $lowerDepth, PDO::PARAM_INT);
                $st->bindValue(":upperDepth", $upperDepth, PDO::PARAM_INT);
            }

            if ($region !== null) {
                $st->bindValue(":region", $region, PDO::PARAM_STR);
            }

            
            if ($type !== null) {
                $st->bindValue(":type", $type, PDO::PARAM_STR);
            }



            $st->execute();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }

        $diveSites = [];

        foreach($st->fetchAll() as $row) {
            $diveSites[] = new DiveSite($row);
        }
        
        return $diveSites;
    }

    public static function getAllAsJSON() {
        $conn = parent::connect();

        $sql = "SELECT * FROM " . TBL_DIVE_SITE;

        try {
            $st = $conn->prepare($sql);
            $st->execute();

            $diveSites = array();

            foreach($st->fetchAll() as $row) {
                $diveSites[] = new DiveSite($row);
            }
        
            parent::disconnect($conn);
            return json_encode($diveSites);
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public static function findById($portfolioItemId) {
        $conn = DataObject::connect();
        $sql = "SELECT * FROM " . TBL_PORTFOLIO_ITEM . " WHERE id = :portfolioItemId";
        $st = $conn->prepare($sql);
        $st->bindValue(":portfolioItemId", $portfolioItemId);
        $st->execute();
        $portfolioItems = array();
                
        foreach($st->fetchAll() as $row) {
            $portfolioItems[] = new PortfolioItem($row);
        }
        parent::disconnect($conn);
        
        return $portfolioItems[0];
    }

    public function jsonSerialize() {
        return $this->data;
    }

    public function delete() {
        $conn = DataObject::connect();
        $sql = 'DELETE FROM ' . TBL_DIVE_SITE . " WHERE id = :diveSiteId";
    
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":diveSiteId", $this->getValue('id'));
            $st->execute();
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
}